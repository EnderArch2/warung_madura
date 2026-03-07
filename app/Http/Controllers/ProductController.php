<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * ProductController — manages the full Product CRUD lifecycle.
 *
 * Laravel Best Practice: "Keep controllers thin."
 * That means: controllers should ONLY (1) receive input, (2) call the Model,
 * and (3) return a view or redirect. Business logic belongs in Service classes
 * or the Model itself (scopes, accessors).
 *
 * REQUEST LIFECYCLE for this controller:
 * 1. Browser sends HTTP request → routes/web.php matches the route
 * 2. Laravel resolves the controller method (e.g., ProductController@store)
 * 3. Middleware runs (e.g., csrf token check on POST)
 * 4. Controller method executes → calls Eloquent model
 * 5. Eloquent queries the database and returns data
 * 6. Controller passes data to the Blade view
 * 7. Blade template is rendered and sent back as HTML
 */
class ProductController extends Controller
{
    /**
     * INDEX — Show a paginated list of all products.
     *
     * WHY paginate() instead of all()?
     * If you have 10,000 products, loading ALL of them at once would be very slow.
     * paginate(10) tells the database: "give me only 10 rows at a time,
     * and track which page we're on via ?page=N in the URL."
     *
     * URL: GET /products
     * Named route: products.index
     */
    public function index()
    {
        // paginate(10) runs:  SELECT * FROM products LIMIT 10 OFFSET 0
        // It also provides a $products->links() method to render page buttons in Blade.
        $products = Product::latest()->paginate(10);

        return view('products.index', [
            'title'    => 'Products',
            'products' => $products,
        ]);
    }

    /**
     * CREATE — Show the empty form for a new product.
     *
     * This method just returns a view — no data fetching needed.
     * URL: GET /products/create
     * Named route: products.create
     */
    public function create()
    {
        return view('products.create', [
            'title' => 'Products',
        ]);
    }

    /**
     * STORE — Validate and persist a new product to the database.
     *
     * WHY validate() here and not in a Form Request class?
     * For a small project this is fine. As the project grows, you'd move
     * the validation rules to:  php artisan make:request StoreProductRequest
     * That keeps controllers even thinner.
     *
     * WHY use $request->validated() instead of $request->all()?
     * validated() only returns the keys that PASSED the validation rules.
     * all() returns EVERYTHING the user sent — potentially dangerous fields
     * like 'id' or 'is_admin' could slip through without $fillable protection.
     *
     * URL: POST /products
     * Named route: products.store
     */
    public function store(Request $request)
    {
        // Validation rules — Laravel automatically returns a 422 response
        // with error messages if any rule fails, and redirects back with old input.
        $validated = $request->validate([
            'serial_number'   => 'required|string|max:10|unique:products,serial_number',
            'name'            => 'required|string|max:50',
            'type'            => 'required|string|max:50',
            'expiration_date' => 'nullable|date',
            'price'           => 'nullable|integer|min:0',
            'stock'           => 'nullable|integer|min:0',
            'picture'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle optional image upload
        if ($request->hasFile('picture')) {
            // store() hashes the file to a unique name and saves it in storage/app/public/products
            // Run:  php artisan storage:link  to make it publicly accessible
            $validated['picture'] = $request->file('picture')->store('products', 'public');
        }

        // mass-assign all validated data — safe because $fillable is set in the Model
        Product::create($validated);

        // Redirect with a flash message — session('success') is read in the Blade view
        return redirect()->route('products.index')
                         ->with('success', 'Product "' . $validated['name'] . '" added successfully.');
    }

    /**
     * SHOW — Display a single product's detail page.
     *
     * findOrFail() is better than find() because:
     * - find($id) returns NULL if not found → causes "calling method on null" errors
     * - findOrFail($id) throws a ModelNotFoundException → Laravel auto-returns a 404 page
     *
     * URL: GET /products/{product}
     * Named route: products.show
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', [
            'title'   => 'Products',
            'product' => $product,
        ]);
    }

    /**
     * EDIT — Show the form pre-filled with an existing product's data.
     *
     * URL: GET /products/{product}/edit
     * Named route: products.edit
     */
    public function edit(string $id)
    {
        // findOrFail automatically triggers a 404 if the ID doesn't exist
        $product = Product::findOrFail($id);

        return view('products.edit', [
            'title'   => 'Products',
            'product' => $product,
        ]);
    }

    /**
     * UPDATE — Validate and persist changes to an existing product.
     *
     * WHY does the HTML form use @method('PUT') if it's a POST form?
     * HTML forms only support GET and POST natively. Laravel uses a hidden
     * _method input to "spoof" PUT/PATCH/DELETE verbs for REST compliance.
     *
     * URL: PUT /products/{product}
     * Named route: products.update
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            // 'unique:products,serial_number,{id}' — ignore THIS product's own serial number
            // so editing without changing the serial number doesn't trigger a "taken" error
            'serial_number'   => 'required|string|max:10|unique:products,serial_number,' . $id,
            'name'            => 'required|string|max:50',
            'type'            => 'required|string|max:50',
            'expiration_date' => 'nullable|date',
            'price'           => 'nullable|integer|min:0',
            'stock'           => 'nullable|integer|min:0',
            'picture'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('products', 'public');
        }

        // update() runs:  UPDATE products SET ... WHERE id = ?
        $product->update($validated);

        return redirect()->route('products.index')
                         ->with('success', 'Product "' . $product->name . '" updated successfully.');
    }

    /**
     * DESTROY — Soft-delete or permanently remove a product.
     *
     * WHY use a form with @method('DELETE') and not a plain <a> link?
     * Browsers only send GET on <a> clicks. Deleting on GET is dangerous
     * (search crawlers or prefetchers could accidentally delete records!).
     * Always use POST/DELETE for destructive actions.
     *
     * URL: DELETE /products/{product}
     * Named route: products.destroy
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $name    = $product->name;

        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product "' . $name . '" deleted successfully.');
    }
}
