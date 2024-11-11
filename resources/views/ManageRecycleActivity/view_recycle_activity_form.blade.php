<x-app-layout>
    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
        <div class="flex justify-between items-center w-auto">
            <p class="font-bold text-md">View Recycle Activity</p>
        </div>
    </div>
    <div class="mt-2 mx-4">
        <form action="{{ route('edit.recycle.activity', $recycleActivity->id) }}" method="POST">
            @csrf
            <div class="flex space-x-6 mt-4">
                <!-- Recycle Category -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_category" class="font-semibold text-sm text-gray mb-2">Recycle Category</label>
                    <x-input name="recycle_category" type="text" placeholder="" value="{{ $recycleActivity->recycle_category }}" disabled/>
                    @error('recycle_category')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Recycle Datetime -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_datetime" class="font-semibold text-sm text-gray mb-2">Recycle Datetime</label>
                    <x-input name="recycle_datetime" type="datetime-local" value="{{ $recycleActivity->recycle_datetime }}" disabled/>
                    @error('recycle_datetime')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Select User -->
                <div class="flex flex-col w-1/2">
                    <label for="user_id" class="font-semibold text-sm text-gray mb-2">User</label>
                    <x-input name="user_id" type="text" value="{{ $recycleActivity->user->name }}" disabled/>
                    @error('user_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Recycle Status -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_status" class="font-semibold text-sm text-gray mb-2">Recycle Status</label>
                    <x-input name="user_id" type="text" value="{{ $recycleActivity->recycle_status }}" disabled/>
                    @error('recycle_status')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Recycle Comment -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_comment" class="font-semibold text-sm text-gray mb-2">Recycle Comment (Max 255)</label>
                    <textarea name="recycle_comment" id="recycle_comment" rows="4" placeholder="" disabled class="bg-white text-gray font-semibold border border-slate-200 focus:border-0 focus:ring-primary-400 focus:ring-1 focus:text-gray-700 rounded-md shadow-sm placeholder:text-sm placeholder:text-slate-400 placeholder:text-opacity-60">{{ $recycleActivity->recycle_comment }}</textarea>
                    @error('recycle_comment')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <style>
                    textarea {
                        resize: vertical; /* Allow vertical resizing */
                        min-height: 40px; /* Set a minimum height */
                        max-height: 150px; /* Set a maximum height */
                    }
                </style>
                
                <!-- Recycle Weight -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_weight" class="font-semibold text-sm text-gray mb-2">Recycle Weight</label>
                    <x-input name="recycle_weight" type="number" placeholder="" value="{{ $recycleActivity->recycle_weight }}" disabled/>
                    @error('recycle_weight')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Recycle Rate -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_rate" class="font-semibold text-sm text-gray mb-2">Recycle Rate</label>
                    <x-input name="recycle_rate" type="text" placeholder="" value="{{ $recycleActivity->recycle_rate }}" disabled/>
                    @error('recycle_rate')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Recycle Price -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_price" class="font-semibold text-sm text-gray mb-2">Recycle Price</label>
                    <x-input name="recycle_price" type="number" placeholder="" value="{{ $recycleActivity->recycle_price }}" disabled/>
                    @error('recycle_price')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Reward Point Earned -->
                <div class="flex flex-col w-1/2">
                    <label for="reward_point_earned" class="font-semibold text-sm text-gray mb-2">Reward Point Earned</label>
                    <x-input name="reward_point_earned" type="number" placeholder="" value="{{ $recycleActivity->reward_point_earned }}" disabled/>
                    @error('reward_point_earned')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div> 

        <!-- Action Buttons -->
        <div class="flex justify-end items-center mt-4">
            <a href="/recycle-activity-list"><x-secondary-button class="mr-2">BACK</x-secondary-button></a>
        </div>
    </div>    
</x-app-layout>