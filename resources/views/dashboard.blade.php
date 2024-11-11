<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex items-stretch mx-10 w-auto">
        @if(auth()->user()->hasRole('admin'))
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#ADEAAF] px-6">
                    <i class="fas fa-cubes fa-xl text-[#365671]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                Products
            </x-slot>
            <x-slot name="data">
                {{ $totalProducts }} <!-- Dynamically show total number of products -->
            </x-slot>
        </x-dashboard-item>
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#f7eea0] px-6">
                    <i class="fas fa-store fa-xl text-[#ab541f]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                Sales
            </x-slot>
            <x-slot name="data">6</x-slot>
        </x-dashboard-item>
        @endif
        @if(auth()->user()->hasRole('user'))
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#faebeb] px-6">
                    <i class="fas fa-gift fa-xl text-[#e63d3d]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                Rewards
            </x-slot>
            <x-slot name="data">
                {{ $totalRewards }} <!-- Dynamically show total number of products -->
            </x-slot>
        </x-dashboard-item>
        @endif
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#B1DEFF] px-6">
                    <i class="fas fa-recycle fa-xl text-[#6f518c]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                Recycle
            </x-slot>
            <x-slot name="data">
                {{ $totalRecycleActivities }} <!-- Dynamically show total number of products -->
            </x-slot>
        </x-dashboard-item>
    </div>

    <x-page-comment>
        <x-slot name="title">
            Page Description
        </x-slot>
        <x-slot name="data">
            {{ auth()->user()->hasRole('admin') ? 
            'Admin able to view products, sales, recycle activities and their chart on this page.' : 
            'You can view your purchase products and recycle activities on this page.' 
           }}        
        </x-slot>
    </x-page-comment>

    <!-- Chart -->
    <div class="mt-8 mx-10 flex">
        <!-- Bar Chart -->
        <div class="w-1/2 pr-4">
            <canvas id="productChart" width="400" height="300"></canvas>
        </div>
        
        @if(auth()->user()->hasRole('admin'))
        <!-- Pie Chart -->
        <div class="w-1/2 pl-8">
            <canvas id="recycleChart" width="400" height="200"></canvas>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get product data from the server
            const productNames = @json($chartProducts->pluck('product_name'));
            const productQuantities = @json($chartProducts->pluck('product_quantity'));

            // Create the chart
            const ctx = document.getElementById('productChart').getContext('2d');
            const productChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: 'Product Quantities',
                        data: productQuantities,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            // Create the pie chart
            const recycleStatus = @json($chartRecycleActivities->pluck('recycle_status'));
            const recycleCounts = @json($chartRecycleActivities->pluck('total'));

            const ctxPie = document.getElementById('recycleChart').getContext('2d');
            const recycleChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: recycleStatus,
                    datasets: [{
                        label: 'Recycle Activity Status',
                        data: recycleCounts,
                        backgroundColor: [
                            '#91D59B',
                            '#EDAD71',
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            '#FF7B00',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Recycle Activity Status'
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
