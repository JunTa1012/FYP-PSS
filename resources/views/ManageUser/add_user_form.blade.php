<x-app-layout>
    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Add User</p>
            </div>
    </div>
    <div class="mt-2 mx-4">
        <form action="{{ route('create.user') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex space-x-6 mt-4">
                <!-- User Name -->
                <div class="flex flex-col w-1/2">
                    <label for="name" class="font-semibold text-sm text-gray mb-2">User Name</label>
                    <x-input name="name" type="text" placeholder="User's Name" required/>
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- User Email -->
                <div class="flex flex-col w-1/2">
                    <label for="email" class="font-semibold text-sm text-gray mb-2">Email</label>
                    <x-input name="email" type="email" placeholder="email" required/>
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- User Phone Number -->
                <div class="flex flex-col w-1/2">
                    <label for="contact_number" class="font-semibold text-sm text-gray mb-2">Contact Number</label>
                    <x-input name="contact_number" type="text" placeholder="01X-XXXXXXXX" required/>
                    @error('contact_number')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Reward Status -->
                <div class="flex flex-col w-1/2">
                    <label for="role" class="font-semibold text-sm text-gray mb-2">Role</label>
                    <select name="role" id="role" required class="border border-gray-300 rounded-md p-2">
                        <option value="" disabled selected>Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} class="font-semibold">Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }} class="font-semibold">User</option>
                    </select>
                    @error('role')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>            
            </div>

            <div class="flex space-x-6 mt-4">
                <div class="flex flex-col w-1/2">
                    <label for="password" class="font-semibold text-sm text-gray mb-2">Password</label>
                    <x-input name="password" type="text" placeholder="password" required/>
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end items-center mt-4">
                <a href="/user-list"><x-secondary-button class="mr-2">CANCEL</x-secondary-button></a>
                <x-button type="submit">Add</x-button>
            </div>
        </form>
    </div>    
</x-app-layout>