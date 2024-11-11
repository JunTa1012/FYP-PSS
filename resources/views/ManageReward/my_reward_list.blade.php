<x-app-layout>
    <div class="flex mx-2 w-auto">
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#e3fdff] px-6">
                    <i class="fas fa-gift fa-xl text-[#3cb0d1]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                {{ Auth::user()->role === 'admin' ? 'Total Reward Redeemed' : 'Total Rewards' }}
            </x-slot>
            <x-slot name="data">
                {{ $totalRewardsCount }}
            </x-slot>
        </x-dashboard-item>

        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#faebeb] px-6">
                    <i class="fas fa-gift fa-xl text-[#e63d3d]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                {{ Auth::user()->role === 'admin' ? 'Pending Rewards' : 'Available Rewards' }}
            </x-slot>
            <x-slot name="data">
                {{ $availableRewardsCount }}
            </x-slot>
        </x-dashboard-item>
    </div>

    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
        <div class="col-span-3">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">My Reward Lists</p>
                <a class="font-bold text-sm text-primary-700">Search</a>
            </div>
            <x-show-table :headers="['Rewards', 'Expired Date', 'Status', 'Redeemed Date', 'Action']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @foreach ($redeemRewards as $i => $redeemReward)
                        <tr class="flex px-8 py-2 {{ ($loop->index % 2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $redeemReward->reward->reward_name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $redeemReward->code_expired_date }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $redeemReward->redeem_code_status }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $redeemReward->code_redeemed_date }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">
                                <a href="{{ route('view.my.reward', $redeemReward->id) }}" class="rounded-full py-2 px-3 bg-blue-100 border border-blue-200 justify-center items-center hover:bg-blue-200 ml-2">
                                    <i class="fa-regular fa-eye text-blue-500 fa-sm"></i>
                                </a>
                            </td>  
                        </tr>
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <a href="/reward-list"><x-secondary-button class="bg-white text-black hover:bg-grey">BACK</x-secondary-button></a>
    </div>
</x-app-layout>
