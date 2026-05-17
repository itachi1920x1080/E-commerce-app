<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // ប្រើសម្រាប់បង្កើតតំណលីង Slug ស្វ័យប្រវត្តិ

class ProductController extends Controller
{
    /**
     * បង្ហាញទំព័រ Form បង្កើតផលិតផល
     */
    public function create()
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $statuses = DB::table('product_statuses')->get();
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.products.create', compact('statuses', 'categories', 'tags'));
    }

    /**
     * ទទួលទិន្នន័យ និង Upload រូបភាពផលិតផល
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ១. Validation ពិនិត្យទិន្នន័យ
        $validated = $request->validate([
            'sku'               => 'required|string|unique:products,sku',
            'name'              => 'required|string|max:255',
            'regular_price'     => 'required|numeric|min:0|max:9999999999',
            'discount_price'    => 'required|numeric|min:0|max:9999999999',
            'currency'          => 'required|string|max:3',
            'product_status_id' => 'required|exists:product_statuses,id',
            'categories'        => 'required|array',
            'categories.*'      => 'exists:categories,id',
            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
            'description'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qty'               => 'required|integer|min:0',
        ]);

        // ២. រៀបចំទិន្នន័យបោះចូល Database
        $productData = [
            'sku'               => $validated['sku'],
            'name'              => $validated['name'],
            'slug'              => Str::slug($validated['name']),
            'regular_price'     => $validated['regular_price'],
            'discount_price'    => $validated['discount_price'],
            
            // 🎯 FIXED: ថែមបន្ទាត់នេះដើម្បីចាប់យកចំនួន Stock បោះទៅឱ្យ Database លែង Error ទៀតហើយ
            'qty'               => $validated['qty'], 
            
            'currency'          => $validated['currency'],
            'product_status_id' => $validated['product_status_id'],
            'description'       => $validated['description'] ?? null,
            'is_free'           => $request->has('is_free') ? 1 : 0,
            'taxable'           => $request->has('taxable') ? 1 : 0,
        ];

        // 📸 ៣. Upload រូបភាពទៅកាន់ Storage
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $productData['image'] = $imagePath;
        }

        // ៤. បង្កើតផលិតផល (លែងគាំង Error ទៀតហើយ)
        $product = Product::create($productData);

        // ៥. ភ្ជាប់ទំនាក់ទំនង Many-to-Many
        $product->categories()->attach($validated['categories']);
        
        if (!empty($validated['tags'])) {
            $product->tags()->attach($validated['tags']);
        }

        return redirect()->back()->with('success', 'Product created successfully with slug and stock quantity! 📦');
    }
    public function index()
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // 🎯 FIXED: ដក with(['categories']) ចេញ ដើម្បីកុំឱ្យវាទាក់ទើបនឹង Error Pivot Table បន្ទាត់ទី 105 ទៀត
        // ប្រព័ន្ធនឹងទាញយកទិន្នន័យផលិតផលសុទ្ធមកបង្ហាញភ្លាមៗ
        $products = Product::orderBy('inserted_at', 'desc')->paginate(10);

        return view('admin.products.index', compact('products'));
    }
    /**
     * បង្ហាញទំព័រ Form កែសម្រួលផលិតផល
     */
    public function edit(Product $product)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $statuses = \Illuminate\Support\Facades\DB::table('product_statuses')->get();
        $categories = Category::all();
        $tags = Tag::all();

        // ទាញយក ID របស់ Category និង Tag ដែលមានស្រាប់ ដើម្បីយកទៅ checked ក្នុង Form
        $productCategoryIds = $product->categories->pluck('id')->toArray();
        $productTagIds = $product->tags->pluck('id')->toArray();

        return view('admin.products.edit', compact('product', 'statuses', 'categories', 'tags', 'productCategoryIds', 'productTagIds'));
    }

    /**
     * ធ្វើបច្ចុប្បន្នភាព (Update) ទិន្នន័យផលិតផល
     */
    public function update(Request $request, Product $product)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ១. Validation
        $validated = $request->validate([
            // 🎯 អនុញ្ញាតឱ្យប្រើ SKU ដដែលបាន តែហាមជាន់ទំនិញផ្សេង
            'sku'               => 'required|string|max:255|unique:products,sku,' . $product->id, 
            'name'              => 'required|string|max:255',
            'regular_price'     => 'required|numeric|min:0|max:9999999999',
            'discount_price'    => 'required|numeric|min:0|max:9999999999|lte:regular_price',
            'qty'               => 'required|integer|min:0',
            'currency'          => 'required|string|max:3',
            'product_status_id' => 'required|exists:product_statuses,id',
            'categories'        => 'required|array',
            'categories.*'      => 'exists:categories,id',
            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
            'description'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ២. រៀបចំទិន្នន័យ
        $productData = [
            'sku'               => $validated['sku'],
            'name'              => $validated['name'],
            'slug'              => \Illuminate\Support\Str::slug($validated['name']),
            'regular_price'     => $validated['regular_price'],
            'discount_price'    => $validated['discount_price'],
            'qty'               => $validated['qty'],
            'currency'          => $validated['currency'],
            'product_status_id' => $validated['product_status_id'],
            'description'       => $validated['description'] ?? null,
            'is_free'           => $request->has('is_free') ? 1 : 0,
            'taxable'           => $request->has('taxable') ? 1 : 0,
        ];

        // ៣. ពិនិត្យ និងអាប់ដេតរូបភាព
        if ($request->hasFile('image')) {
            // លុបរូបចាស់ចេញពី Storage
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            // Upload រូបថ្មី
            $productData['image'] = $request->file('image')->store('products', 'public');
        }

        // ៤. Update ចូល Database
        $product->update($productData);

        // ៥. Update តារាងបង្កាត់ (Pivot Tables)
        $product->categories()->sync($validated['categories']);
        
        if (!empty($validated['tags'])) {
            $product->tags()->sync($validated['tags']);
        } else {
            $product->tags()->detach();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully! 📦');
    }

    /**
     * លុប (Delete) ផលិតផល
     */
    public function destroy(Product $product)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ១. លុបរូបភាពពី Storage សិន
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        // ២. ផ្តាច់ទំនាក់ទំនង Pivot tables 
        $product->categories()->detach();
        $product->tags()->detach();

        // ៣. លុបផលិតផល
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}