<x-app-layout>
    <div class="container">
        <h2>Inventory</h2>

        <!-- Search and Add New Product Button -->
        <div class="row mb-3">
            <div class="col">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search products..." name="search">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="col text-right">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
            </div>
        </div>

        <!-- Products Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <a href="{{ route('products.show', ['product' => $product]) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('products.edit', ['product' => $product]) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', ['product' => $product]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete {{ $product->name }}?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>