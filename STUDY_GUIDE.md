# 📚 Warung Madura — Laravel Study Guide

> This file is automatically updated every time a new feature is implemented.
> Each section breaks down **what was built**, **why specific Laravel tools were chosen**, and **exercises** for you to try.

---

## Feature 1: Product CRUD

### 📋 Overview
A full **Create, Read, Update, Delete** system for the `products` table, including:
- Paginated product listing with stock badges
- Create form with image upload
- Edit form with current-image preview
- SweetAlert2 delete confirmation
- 10 seeded sample products

---

### 🔄 Request Lifecycle: How a Page is Served

When you visit `http://127.0.0.1:8000/products`, here is **exactly** what happens inside Laravel, step by step:

```
Browser Request
      │
      ▼
 routes/web.php
 Route::resource('/products', ProductController::class)
 → Matches GET /products → calls ProductController@index
      │
      ▼
 Middleware Stack (runs BEFORE controller)
 ├─ CheckForMaintenanceMode  (is the site down?)
 ├─ EncryptCookies           (encrypt session cookies)
 ├─ StartSession             (load the session)
 ├─ VerifyCsrfToken          (only for POST/PUT/DELETE)
 └─ ShareErrorsFromSession   (makes $errors available in all views)
      │
      ▼
 ProductController::index()
 $products = Product::latest()->paginate(10);
 return view('products.index', ['products' => $products]);
      │
      ▼
 Eloquent ORM
 Executes SQL:  SELECT * FROM `products` ORDER BY created_at DESC LIMIT 10 OFFSET 0
      │
      ▼
 Blade Template Engine
 Renders resources/views/products/index.blade.php
 Injects $products data into the HTML
      │
      ▼
 HTTP Response → sent back to browser
```

---

### 🗃️ Eloquent Query Explanation: `Product::latest()->paginate(10)`

```php
// In ProductController::index()
$products = Product::latest()->paginate(10);
```

This is actually **3 methods chained together**:

| Part | What it does | SQL equivalent |
|------|-------------|----------------|
| `Product::` | Start a query on the `products` table | `SELECT * FROM products` |
| `latest()` | Order by `created_at` DESC | `ORDER BY created_at DESC` |
| `paginate(10)` | Fetch only 10 rows, track pages via `?page=N` | `LIMIT 10 OFFSET 0` |

**Why `paginate()` and NOT `all()`?**
- `Product::all()` fetches **every single row** from the database into PHP memory.
- If you have 10,000 products, that's 10,000 PHP objects instantiated at once — very slow and memory-heavy.
- `paginate(10)` only fetches **10 rows at a time**, and provides `$products->links()` in Blade which renders page navigation buttons automatically.

---

### 🛡️ Why `$fillable` in the Model?

```php
// In app/Models/Product.php
protected $fillable = [
    'serial_number', 'name', 'type',
    'expiration_date', 'price', 'stock', 'picture',
];
```

**Without `$fillable`**, doing `Product::create($request->all())` would throw a `MassAssignmentException`.

**The security reason:** Imagine a user adds a hidden field `<input name="is_admin" value="1">` to the form. Without `$fillable`, Laravel would blindly save that field to the database, granting the user admin access. `$fillable` acts as an explicit **allowlist** — only listed columns can be mass-assigned.

---

### 🔒 Why `@csrf` in Every Form?

```html
<form action="{{ route('products.store') }}" method="POST">
    @csrf  {{-- Outputs: <input type="hidden" name="_token" value="abc123..."> --}}
```

**CSRF = Cross-Site Request Forgery**

Imagine you're logged into Warung Madura. A hacker tricks you into visiting a malicious page that has:
```html
<form action="http://127.0.0.1:8000/products" method="POST">
    <input name="name" value="Hacked Product">
</form>
<script>document.forms[0].submit()</script>
```

Your browser would automatically send your session cookie, and without CSRF protection, the product would be created! The `@csrf` token is **unique per session** and the hacker can't guess it, so laravel rejects the request with a `419` error.

---

### 🔁 Why `@method('PUT')` in the Edit Form?

```html
<form action="{{ route('products.update', $product->id) }}" method="POST">
    @method('PUT')  {{-- Outputs: <input type="hidden" name="_method" value="PUT"> --}}
```

**The problem:** HTML forms only support `GET` and `POST`. REST convention requires `PUT` for updates and `DELETE` for deletions.

**The solution:** Laravel reads the hidden `_method` field and routes it as if it were a `PUT` request. This is called **"method spoofing"** — the browser sends POST, but Laravel treats it as PUT.

---

### ⚙️ Why `old('name', $product->name)` in the Edit Form?

```php
// Two-argument old():
value="{{ old('name', $product->name) }}"
```

| Scenario | What happens |
|----------|-------------|
| **First page load** | `old('name')` is empty, so uses `$product->name` as fallback |
| **After failed validation** | `old('name')` has the value the user typed before the error, so it's restored |

Without `old()`, every failed validation would wipe the form clean — very frustrating UX.

---

### 📅 Why `$casts` for `expiration_date`?

```php
// In the Product Model:
protected $casts = [
    'expiration_date' => 'date',
];
```

The database stores `expiration_date` as a plain string: `"2026-12-31"`.

With `'date'` cast, Eloquent automatically wraps it in a **Carbon** object, giving you:
```php
// In the Blade view:
$product->expiration_date->format('d M Y')  // → "31 Dec 2026"
$product->expiration_date->isPast()         // → true/false
$product->expiration_date->diffForHumans()  // → "in 9 months"
```

Without `$casts`, `$product->expiration_date` is just a plain string `"2026-12-31"` and you'd have to manually convert it with `Carbon::parse()` every time.

---

### 🎯 Local Query Scope: `scopeLowStock()`

```php
// Defined in the Product Model:
public function scopeLowStock($query, $threshold = 5)
{
    return $query->where('stock', '<=', $threshold);
}
```

**Without scope:**
```php
Product::where('stock', '<=', 5)->get();    // works, but repeated everywhere
Product::where('stock', '<=', 10)->get();   // harder to read
```

**With scope:**
```php
Product::lowStock()->get();       // threshold = 5 (default)
Product::lowStock(10)->get();     // threshold = 10 (custom)
```

Scopes make complex queries **readable, reusable, and testable**.

---

### ✍️ 3 Exercises for You to Try

#### Exercise 1: Write a Pest/PHPUnit Test for the Product List
```php
// Create: tests/Feature/ProductTest.php
// Then run:  php artisan test

test('products index page loads successfully', function () {
    $response = $this->get('/products');
    $response->assertStatus(200);
    $response->assertSee('Products Table');
});

test('product can be created', function () {
    $response = $this->post('/products', [
        'serial_number' => 'TST-001',
        'name'          => 'Test Product',
        'type'          => 'Test Category',
        'price'         => 1000,
        'stock'         => 10,
    ]);
    $response->assertRedirect('/products');
    $this->assertDatabaseHas('products', ['serial_number' => 'TST-001']);
});
```
> **Challenge:** Add a test for the validation — submit an empty form and assert that you get redirected back with errors.

---

#### Exercise 2: Add a `unit` Column to Products

1. Create a new migration:
   ```bash
   php artisan make:migration add_unit_to_products_table --table=products
   ```
2. In the migration file, add:
   ```php
   $table->string('unit', 20)->default('pcs')->after('stock');
   // Examples: pcs, kg, liter, box
   ```
3. Run it:  `php artisan migrate`
4. Add `'unit'` to `$fillable` in the `Product` model
5. Add the `unit` input field to `create.blade.php` and `edit.blade.php`
6. Show it in the `index.blade.php` table

---

#### Exercise 3: Implement `scopeLowStock()` on the Dashboard

In `DashboardController::index()`, use the scope you already have:
```php
use App\Models\Product;

public function index()
{
    return view('dashboard.index', [
        'title'          => 'Dashboard',
        'lowStockCount'  => Product::lowStock()->count(),
        'lowStockItems'  => Product::lowStock()->get(),
    ]);
}
```

Then in `dashboard/index.blade.php`, add a warning card when `$lowStockCount > 0`:
```html
@if ($lowStockCount > 0)
    <div class="alert alert-warning">
        ⚠️ {{ $lowStockCount }} products are running low on stock!
    </div>
@endif
```

---

## Feature 2: Sale Reports (Dashboard)

### 📋 Overview
A complete dashboard wiring showing real-time metrics from the `sales` and `sale_details` tables.
- **Stat Cards:** Today's Revenue, Total Products (with low stock alert), This Month's Sales/Revenue.
- **Charts:** 9-month historical trends using Chart.js powered by aggregate Eloquent queries.
- **Tables:** Top Selling Products (grouped by quantity) and Recent Sales timeline.

---

### 🚄 Eager Loading vs Lazy Loading

```php
// In DashboardController.php
$recentSales = Sale::with(['saleDetails.product'])->latest('sale_date')->take(6)->get();
```

**The N+1 Problem (Lazy Loading):**
If you did `Sale::latest()->get()` and then in the Blade file looped through to get `$sale->saleDetails->product->name`, Laravel would run 1 query to get the sales, and then **for every single sale**, it would run additional queries to find its details and products. For 6 sales, that's 1 + 6 + 6 = 13 queries. For 100 sales, it's 201 queries!

**The Solution (Eager Loading):**
By adding `->with(['saleDetails.product'])`, Laravel runs exactly **3 queries** total:
1. Get 6 sales.
2. Get all `sale_details` where `sale_id` IN (1, 2, 3, 4, 5, 6).
3. Get all `products` matching those details.
This is massively faster!

---

### 📊 Grouping and Aggregating with SQL in Eloquent

To render the charts, we needed a count of transactions per month for the last 9 months.
Instead of running 9 separate `whereMonth()` queries, we used one powerful query:

```php
$monthlyCounts = Sale::where('sale_date', '>=', $nineMonthsAgo)
    ->selectRaw('MONTH(sale_date) as month, YEAR(sale_date) as year, COUNT(*) as count')
    ->groupBy('year', 'month')
    ->get();
```
- `selectRaw` lets us use raw SQL functions like `MONTH()` and `COUNT()`.
- `groupBy` tells the database to group the results by the year and month.
This is much more efficient than fetching all sales and grouping them in PHP memory!

---

### 🌉 Passing PHP Data to JavaScript (`json_encode`)

Chart.js needs JavaScript format, but our data is in PHP variables.
We passed it safely using Blade:

```html
labels: {!! json_encode($barLabels) !!},
```
This securely converts the PHP array `['Mar', 'Apr', 'May']` into a literal JavaScript array format `["Mar", "Apr", "May"]`. `json_encode` is the bulletproof native PHP method to ensure data is safely sent to JavaScript without breaking syntax (unlike using `implode()`).

---

*Last updated: March 2026 — Feature 2 (Sale Reports) completed.*

## Feature 3: Sale and Sale Reports Pages

### 📋 Overview
A complete Point-of-Sale (POS) interface and detailed tabular reporting system.
- **Dynamic Cart Form:** Built with pure Vanilla JS, allowing users to select products, specify quantities, and see real-time subtotal calculations while preventing overselling based on current stock.
- **Database Transactions:** Ensuring that complex multi-table inserts (Sale header, multiple Sale Details, and stock deductions) either entirely succeed or entirely rollback without corrupting data.

---

### 🛡️ Why Use Database Transactions?

When creating a sale with multiple items, several things happen in the database:
1. Insert generic record into `sales` (total price, date).
2. For each product bought:
   - Insert line item into `sale_details`.
   - Update `products` table to decrement stock (`stock = stock - qty`).

**The Danger:**
What happens if step 1 works, the first product works, but the second product fails (e.g., database connection error)?
- The user is charged for 2 products.
- The system only recorded 1 line item.
- Stock for only 1 product was reduced.
**Result:** Corrupted financial data!

**The Solution: `DB::transaction()`**
```php
DB::beginTransaction();
try {
    $sale = Sale::create([...]);
    foreach ($items as $item) {
        SaleDetail::create([...]);
        Product::where(...)->decrement('stock', $qty);
    }
    DB::commit(); // Saves EVERYTHING to the database at once!
} catch (\Exception $e) {
    DB::rollBack(); // UNDOES everything if any single query failed!
}
```
Transactions guarantee **Atomicity** — either all the queries work together, or none of them do.

---

### ⚡ Passing Backend Logic to Vanilla JS

In `sales/create.blade.php`, we built a responsive POS cart without needing React or Vue.
We did this by securely passing the product catalog to Javascript:

```php
// In the Controller
$productsList = $products->map(function($p) {
    return [
        'serial' => $p->serial_number,
        'name'   => $p->name,
        'price'  => $p->price,
        'stock'  => $p->stock
    ];
})->toArray();
```

```html
<!-- In the Blade View -->
<script>
    const productsList = {!! json_encode($productsList) !!};
    
    // Now Javascript has an array of objects!
    // -> [{serial: "PRD-001", name: "Indomie", price: 3500, stock: 150}, ...]
</script>
```

By passing this array, the Javascript on the browser's end can instantly lookup prices (`$p->price`) and validate maximum quantities (`$p->stock`) the moment a user selects a dropdown option, without needing to make slow AJAX requests to the server for every click.

---

*Last updated: March 2026 — Feature 3 (Sale & Sale Reports Pages) completed.*
