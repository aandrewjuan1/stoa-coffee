<x-app-layout>
    <div class="grid grid-cols-2 gap-5 mx-20 px-4 py-4 text-gray-900 dark:text-gray-200">
        <div>
            <h1 class="flex justify-center text-2xl font-bold">Pending Orders</h1>
            <div class="mt-4 space-y-4">
                @foreach($pendingOrders as $order)
                    <a href="{{ route('orders.show', $order->id) }}">
                        <div class="mb-4 bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg cursor-pointer dark:bg-gray-800">
                            <div class="px-4 py-3">
                                <h2 class="text-lg font-bold mb-2">Order #{{ $order->id }}</h2>
                                <table class="min-w-full">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">User:</td>
                                            <td class="py-2 px-4">{{ $order->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">Date:</td>
                                            <td class="py-2 px-4">{{ $order->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">Total Price:</td>
                                            <td class="py-2 px-4">₱{{ $order->total_price }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">Total Items:</td>
                                            <td class="py-2 px-4">
                                                @php
                                                    $totalItems = 0;
                                                    foreach ($order->orderItems as $item) {
                                                        $totalItems += $item->quantity;
                                                    }
                                                    echo $totalItems;
                                                @endphp
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h1 class="flex justify-center text-2xl font-bold">Processing Orders</h1>
            <div class="mt-4 space-y-4">
                @foreach($processingOrders as $order)
                    <a href="{{ route('orders.show', $order->id) }}">
                        <div class="mb-4 bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg cursor-pointer dark:bg-gray-800">
                            <div class="px-4 py-3">
                                <h2 class="text-lg font-bold mb-2">Order #{{ $order->id }}</h2>
                                <table class="min-w-full">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">User:</td>
                                            <td class="py-2 px-4">{{ $order->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">Date:</td>
                                            <td class="py-2 px-4">{{ $order->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">Total Price:</td>
                                            <td class="py-2 px-4">₱{{ $order->total_price }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-4 font-semibold">Total Items:</td>
                                            <td class="py-2 px-4">
                                                @php
                                                    $totalItems = 0;
                                                    foreach ($order->orderItems as $item) {
                                                        $totalItems += $item->quantity;
                                                    }
                                                    echo $totalItems;
                                                @endphp
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
