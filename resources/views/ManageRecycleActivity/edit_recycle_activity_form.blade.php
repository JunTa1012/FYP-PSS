<x-app-layout>
    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Edit Recycle Activity</p>
            </div>
    </div>
    <div class="mt-2 mx-4">
        <form action="{{ route('edit.recycle.activity', $recycleActivity->id) }}" method="POST">
            @csrf
            <div class="flex space-x-6 mt-4">
                <!-- Recycle Category -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_category" class="font-semibold text-sm text-gray mb-2">Recycle Category</label>
                    <x-input name="recycle_category" type="text" placeholder="" value="{{ $recycleActivity->recycle_category }}" required/>
                    @error('recycle_category')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Recycle Datetime -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_datetime" class="font-semibold text-sm text-gray mb-2">Recycle Datetime</label>
                    <x-input name="recycle_datetime" type="datetime-local" value="{{ $recycleActivity->recycle_datetime }}" required/>
                    @error('recycle_datetime')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Select User -->
                <div class="flex flex-col w-1/2">
                    <label for="user_id" class="font-semibold text-sm text-gray mb-2">Select User</label>
                    <select name="user_id" id="user_id" class="block w-full pl-10 pr-10 py-2 text-base border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $recycleActivity->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Recycle Status -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_status" class="font-semibold text-sm text-gray mb-2">Recycle Status</label>
                    <select name="recycle_status" id="recycle_status" required class="border border-gray-300 rounded-md p-2">
                        <option value="" disabled selected>Select Status</option>
                        @foreach($recycleStatus as $status)
                            <option value="{{ $status }}" {{ $recycleActivity->recycle_status == $status ? 'selected' : '' }} class="font-semibold">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Recycle Comment -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_comment" class="font-semibold text-sm text-gray mb-2">Recycle Comment (Max 255)</label>
                    <textarea name="recycle_comment" rows="3" placeholder="" required class="bg-white text-gray font-semibold border border-slate-200 focus:border-0 focus:ring-primary-400 focus:ring-1 focus:text-gray-700 rounded-md shadow-sm placeholder:text-sm placeholder:text-slate-400 placeholder:text-opacity-60">{{ $recycleActivity->recycle_comment }}</textarea>
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
                    <label for="recycle_weight" class="font-semibold text-sm text-gray mb-2">Recycle Weight (Kg)</label>
                    <x-input name="recycle_weight" type="number" placeholder="" value="{{ $recycleActivity->recycle_weight }}" required id="recycle_weight" oninput="calculatePrice()"/>
                    @error('recycle_weight')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Recycle Rate -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_rate" class="font-semibold text-sm text-gray mb-2">Recycle Rate</label>
                    <x-input name="recycle_rate" type="text" placeholder="" value="{{ $recycleActivity->recycle_rate }}" required id="recycle_rate" oninput="calculatePrice()"/>
                    @error('recycle_rate')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Recycle Price -->
                <div class="flex flex-col w-1/2">
                    <label for="recycle_price" class="font-semibold text-sm text-gray mb-2">Recycle Price</label>
                    <x-input name="recycle_price" type="number" placeholder="" value="{{ $recycleActivity->recycle_price }}" id="recycle_price" readonly/>
                    @error('recycle_price')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Reward Point Earned -->
                <div class="flex flex-col w-1/2">
                    <label for="reward_point_earned" class="font-semibold text-sm text-gray mb-2">Reward Point Earned</label>
                    <x-input name="reward_point_earned" type="number" placeholder="" value="{{ $recycleActivity->reward_point_earned }}" id="reward_point_earned" readonly/>
                    @error('reward_point_earned')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center mt-4">
                <a href="/recycle-activity-list"><x-secondary-button class="mr-2">CANCEL</x-secondary-button></a>
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </div>    
</x-app-layout>

<script>
    function calculatePrice() {
        var recycleWeight = document.getElementById('recycle_weight').value;
        var recycleRate = document.getElementById('recycle_rate').value;
        var recyclePrice = recycleWeight * recycleRate;
        document.getElementById('recycle_price').value = recyclePrice;
        var rewardPointEarned = Math.round(recyclePrice);
        document.getElementById('reward_point_earned').value = rewardPointEarned;
    }
</script>