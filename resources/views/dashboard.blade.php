<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto space-y-6">
        <form method="GET" action="{{ route('dashboard.index') }}" class="bg-white p-4 rounded-xl shadow-sm grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <div class="p-6 space-y-8">
        <div class="max-w-7xl mx-auto px-4 space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Number of Transactions by Currency</h2>
                    <ul class="divide-y divide-gray-200">
                        @foreach ($transaction_reports->data as $item)
                            <li class="py-2 flex justify-between">
                                <span class="text-gray-600 font-medium">{{ $item['currency'] }}</span>
                                <span class="text-gray-900 font-bold">{{ $item['count'] }} işlem</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            
                <div class="bg-white p-4 rounded-xl shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Total Amount by Currency</h2>
                    <ul class="divide-y divide-gray-200">
                        @foreach ($transaction_reports->data as $item)
                            <li class="py-2 flex justify-between">
                                <span class="text-gray-600 font-medium">{{ $item['currency'] }}</span>
                                <span class="text-gray-900 font-bold">{{ number_format($item['total']) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction Amounts Chart</h2>
                <canvas id="currencyChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const ctx = document.getElementById('currencyChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(array_column($transaction_reports->data, 'currency')),
                datasets: [{
                    label: 'Total Amount',
                    data: @json(array_column($transaction_reports->data, 'total')),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        type: 'logarithmic',
                        title: {
                            display: true,
                            text: 'Total Amount'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
