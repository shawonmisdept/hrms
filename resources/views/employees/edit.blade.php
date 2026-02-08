@extends('layouts.dashboard') {{-- Apnar main dashboard layout file --}}

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="bg-blue-600 text-white p-4 rounded-t-lg">
            <h4 class="text-xl font-semibold">Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h4>
        </div>
        <div class="p-4">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative mb-3 text-sm" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">There were some problems with your input.</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Use PUT method for updates --}}

                {{-- Personal Information Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Personal Information</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        {{-- Photo Upload --}}
                        <div class="md:col-span-3 flex flex-col items-center justify-center">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                            <div class="mb-3">
                                {{-- Corrected image source to use emp_photo and default image --}}
                                <img id="photo-preview" src="{{ $employee->emp_photo ? asset('storage/employee_photos/' . $employee->emp_photo) : asset('images/default_profile.png') }}"
                                     alt="Employee Photo" class="w-32 h-32 rounded-md object-cover border-2 border-gray-300 bg-gray-200">
                            </div>
                            <input type="file" class="hidden" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)">
                            <label for="photo" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white font-bold py-1.5 px-3 rounded focus:outline-none focus:shadow-outline text-sm">
                                Change Photo
                            </label>
                            @if($employee->emp_photo)
                                {{-- "Remove Photo" checkbox for robust handling --}}
                                <div class="mt-2 flex items-center">
                                    <input type="checkbox" name="remove_photo" id="remove_photo" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                    <label for="remove_photo" class="ml-2 text-sm text-gray-600">Remove Photo</label>
                                </div>
                            @endif
                            @error('photo')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Personal Details --}}
                        <div class="md:col-span-9 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="salutation" class="block text-sm font-medium text-gray-700">Salutation <span class="text-red-500">*</span></label>
                                <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('salutation') border-red-500 @enderror" id="salutation" name="salutation" required>
                                    <option value="">Select Salutation</option>
                                    <option value="Mr." {{ old('salutation', $employee->salutation) == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                    <option value="Ms." {{ old('salutation', $employee->salutation) == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                    <option value="Mrs." {{ old('salutation', $employee->salutation) == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                    <option value="Dr." {{ old('salutation', $employee->salutation) == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                </select>
                                @error('salutation')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('first_name') border-red-500 @enderror" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                                @error('first_name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('middle_name') border-red-500 @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}">
                                @error('middle_name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('last_name') border-red-500 @enderror" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                                @error('last_name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700">Father's Name</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('father_name') border-red-500 @enderror" id="father_name" name="father_name" value="{{ old('father_name', $employee->father_name) }}">
                                @error('father_name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700">Mother's Name</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('mother_name') border-red-500 @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name', $employee->mother_name) }}">
                                @error('mother_name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" class="datepicker mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('dob') border-red-500 @enderror" id="dob" name="dob" value="{{ old('dob', $employee->dob ? \Carbon\Carbon::parse($employee->dob)->format('m/d/Y') : '') }}" placeholder="mm/dd/yyyy" required>
                                    <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                                @error('dob')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                                <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('gender') border-red-500 @enderror" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                                <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('religion') border-red-500 @enderror" id="religion" name="religion">
                                    <option value="">Select Religion</option>
                                    <option value="Islam" {{ old('religion', $employee->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Hinduism" {{ old('religion', $employee->religion) == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                    <option value="Christianity" {{ old('religion', $employee->religion) == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                                    <option value="Buddhism" {{ old('religion', $employee->religion) == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                                    <option value="Other" {{ old('religion', $employee->religion) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('religion')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group</label>
                                <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('blood_group') border-red-500 @enderror" id="blood_group" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group', $employee->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group', $employee->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group', $employee->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group', $employee->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group', $employee->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group', $employee->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_group', $employee->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group', $employee->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="education_id" class="block text-sm font-medium text-gray-700">Last Education Level</label>
                                <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('education_id') border-red-500 @enderror" id="education_id" name="education_id">
                                    <option value="">Select Education Level</option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}" {{ old('education_id', $employee->education_id) == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                    @endforeach
                                </select>
                                @error('education_id')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="id_type" class="block text-sm font-medium text-gray-700">ID Type</label>
                                <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('id_type') border-red-500 @enderror" id="id_type" name="id_type">
                                    <option value="">Select ID Type</option>
                                    <option value="NID" {{ old('id_type', $employee->id_type) == 'NID' ? 'selected' : '' }}>NID</option>
                                    <option value="Passport" {{ old('id_type', $employee->id_type) == 'Passport' ? 'selected' : '' }}>Passport</option>
                                    <option value="Birth Certificate" {{ old('id_type', $employee->id_type) == 'Birth Certificate' ? 'selected' : '' }}>Birth Certificate</option>
                                </select>
                                @error('id_type')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-1">
                                <label for="id_number" class="block text-sm font-medium text-gray-700">ID Number</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('id_number') border-red-500 @enderror" id="id_number" name="id_number" value="{{ old('id_number', $employee->id_number) }}">
                                @error('id_number')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('phone') border-red-500 @enderror" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}">
                                @error('phone')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('mobile') border-red-500 @enderror" id="mobile" name="mobile" value="{{ old('mobile', $employee->mobile) }}">
                                @error('mobile')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Present Address Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Present Address</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="present_address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_address') border-red-500 @enderror" id="present_address" name="present_address" value="{{ old('present_address', $employee->present_address) }}">
                            @error('present_address')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="present_po" class="block text-sm font-medium text-gray-700">Post Office</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_po') border-red-500 @enderror" id="present_po" name="present_po" value="{{ old('present_po', $employee->present_po) }}">
                            @error('present_po')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="present_ps" class="block text-sm font-medium text-gray-700">Police Station</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_ps') border-red-500 @enderror" id="present_ps" name="present_ps" value="{{ old('present_ps', $employee->present_ps) }}">
                            @error('present_ps')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="present_zip" class="block text-sm font-medium text-gray-700">Zip Code</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_zip') border-red-500 @enderror" id="present_zip" name="present_zip" value="{{ old('present_zip', $employee->present_zip) }}">
                            @error('present_zip')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="present_district" class="block text-sm font-medium text-gray-700">District</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_district') border-red-500 @enderror" id="present_district" name="present_district">
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->name }}" {{ old('present_district', $employee->present_district) == $district->name ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('present_district')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="present_upazila_id" class="block text-sm font-medium text-gray-700">Upazila</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_upazila_id') border-red-500 @enderror" id="present_upazila_id" name="present_upazila_id">
                                <option value="">Select Upazila</option>
                                @foreach($upazilas as $upazila)
                                    <option value="{{ $upazila->id }}" {{ old('present_upazila_id', $employee->present_upazila_id) == $upazila->id ? 'selected' : '' }}>{{ $upazila->name }}</option>
                                @endforeach
                            </select>
                            @error('present_upazila_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="present_country" class="block text-sm font-medium text-gray-700">Country</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('present_country') border-red-500 @enderror" id="present_country" name="present_country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}" {{ old('present_country', $employee->present_country) == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('present_country')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Permanent Address Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Permanent Address</h5>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" id="same_as_present_address" {{ old('same_as_present_address', $employee->present_address == $employee->permanent_address && $employee->present_po == $employee->permanent_po && $employee->present_ps == $employee->permanent_ps && $employee->present_zip == $employee->permanent_zip && $employee->present_district == $employee->permanent_district && $employee->present_upazila_id == $employee->permanent_upazila_id && $employee->present_country == $employee->permanent_country) ? 'checked' : '' }}>
                        <label for="same_as_present_address" class="ml-2 block text-sm leading-5 text-gray-900">
                            Same as Present Address
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="permanent_address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_address') border-red-500 @enderror" id="permanent_address" name="permanent_address" value="{{ old('permanent_address', $employee->permanent_address) }}">
                            @error('permanent_address')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="permanent_po" class="block text-sm font-medium text-gray-700">Post Office</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_po') border-red-500 @enderror" id="permanent_po" name="permanent_po" value="{{ old('permanent_po', $employee->permanent_po) }}">
                            @error('permanent_po')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="permanent_ps" class="block text-sm font-medium text-gray-700">Police Station</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_ps') border-red-500 @enderror" id="permanent_ps" name="permanent_ps" value="{{ old('permanent_ps', $employee->permanent_ps) }}">
                            @error('permanent_ps')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="permanent_zip" class="block text-sm font-medium text-gray-700">Zip Code</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_zip') border-red-500 @enderror" id="permanent_zip" name="permanent_zip" value="{{ old('permanent_zip', $employee->permanent_zip) }}">
                            @error('permanent_zip')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="permanent_district" class="block text-sm font-medium text-gray-700">District</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_district') border-red-500 @enderror" id="permanent_district" name="permanent_district">
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->name }}" {{ old('permanent_district', $employee->permanent_district) == $district->name ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('permanent_district')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="permanent_upazila_id" class="block text-sm font-medium text-gray-700">Upazila</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_upazila_id') border-red-500 @enderror" id="permanent_upazila_id" name="permanent_upazila_id">
                                <option value="">Select Upazila</option>
                                @foreach($upazilas as $upazila)
                                    <option value="{{ $upazila->id }}" {{ old('permanent_upazila_id', $employee->permanent_upazila_id) == $upazila->id ? 'selected' : '' }}>{{ $upazila->name }}</option>
                                @endforeach
                            </select>
                            @error('permanent_upazila_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="permanent_country" class="block text-sm font-medium text-gray-700">Country</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('permanent_country') border-red-500 @enderror" id="permanent_country" name="permanent_country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}" {{ old('permanent_country', $employee->permanent_country) == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('permanent_country')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Contact & Emergency Contact Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Emergency Contact</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-3">
                            <label for="guardian_number" class="block text-sm font-medium text-gray-700">Guardian Number</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('guardian_number') border-red-500 @enderror" id="guardian_number" name="guardian_number" value="{{ old('guardian_number', $employee->guardian_number) }}">
                            @error('guardian_number')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-3">
                            <label for="ref_address" class="block text-sm font-medium text-gray-700">Reference Address</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('ref_address') border-red-500 @enderror" id="ref_address" name="ref_address" value="{{ old('ref_address', $employee->ref_address) }}">
                            @error('ref_address')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Marital Status & Children Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Marital Status & Children</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('marital_status') border-red-500 @enderror" id="marital_status" name="marital_status">
                                <option value="">Select Status</option>
                                <option value="Single" {{ old('marital_status', $employee->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('marital_status', $employee->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Divorced" {{ old('marital_status', $employee->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="Widowed" {{ old('marital_status', $employee->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                            @error('marital_status')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="spouse_name" class="block text-sm font-medium text-gray-700">Spouse Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('spouse_name') border-red-500 @enderror" id="spouse_name" name="spouse_name" value="{{ old('spouse_name', $employee->spouse_name) }}">
                            @error('spouse_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="spouse_number" class="block text-sm font-medium text-gray-700">Spouse Contact Number</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('spouse_number') border-red-500 @enderror" id="spouse_number" name="spouse_number" value="{{ old('spouse_number', $employee->spouse_number) }}">
                            @error('spouse_number')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="no_of_children" class="block text-sm font-medium text-gray-700">Number of Children</label>
                            <input type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('no_of_children') border-red-500 @enderror" id="no_of_children" name="no_of_children" value="{{ old('no_of_children', $employee->no_of_children) }}" min="0">
                            @error('no_of_children')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Official Information Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Official Information</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-1">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID <span class="text-red-500">*</span></label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('employee_id') border-red-500 @enderror" id="employee_id" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}" required>
                            @error('employee_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="employee_code" class="block text-sm font-medium text-gray-700">Employee Code</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('employee_code') border-red-500 @enderror" id="employee_code" name="employee_code" value="{{ old('employee_code', $employee->employee_code) }}">
                            @error('employee_code')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('status') border-red-500 @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Pending" {{ old('status', $employee->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Blocked" {{ old('status', $employee->status) == 'Blocked' ? 'selected' : '' }}>Blocked</option>
                                <option value="Suspended" {{ old('status', $employee->status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('unit_id') border-red-500 @enderror" id="unit_id" name="unit_id">
                                <option value="">Select Unit</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id', $employee->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department <span class="text-red-500">*</span></label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('department_id') border-red-500 @enderror" id="department_id" name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="designation_id" class="block text-sm font-medium text-gray-700">Designation <span class="text-red-500">*</span></label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('designation_id') border-red-500 @enderror" id="designation_id" name="designation_id" required>
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                                @endforeach
                            </select>
                            @error('designation_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('section_id') border-red-500 @enderror" id="section_id" name="section_id">
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ old('section_id', $employee->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="division_id" class="block text-sm font-medium text-gray-700">Division</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('division_id') border-red-500 @enderror" id="division_id" name="division_id">
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division_id', $employee->division_id) == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="line_id" class="block text-sm font-medium text-gray-700">Line</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('line_id') border-red-500 @enderror" id="line_id" name="line_id">
                                <option value="">Select Line</option>
                                @foreach($lines as $line)
                                    <option value="{{ $line->id }}" {{ old('line_id', $employee->line_id) == $line->id ? 'selected' : '' }}>{{ $line->name }}</option>
                                @endforeach
                            </select>
                            @error('line_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="join_date" class="block text-sm font-medium text-gray-700">Join Date <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" class="datepicker mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('join_date') border-red-500 @enderror" id="join_date" name="join_date" value="{{ old('join_date', $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('m/d/Y') : '') }}" placeholder="mm/dd/yyyy" required>
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            @error('join_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="staff_category_id" class="block text-sm font-medium text-gray-700">Staff Category</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('staff_category_id') border-red-500 @enderror" id="staff_category_id" name="staff_category_id">
                                <option value="">Select Category</option>
                                @foreach($staffCategories as $category)
                                    <option value="{{ $category->id }}" {{ old('staff_category_id', $employee->staff_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('staff_category_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="salary_grade_id" class="block text-sm font-medium text-gray-700">Salary Grade</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('salary_grade_id') border-red-500 @enderror" id="salary_grade_id" name="salary_grade_id">
                                <option value="">Select Grade</option>
                                @foreach($salaryGrades as $grade)
                                    <option value="{{ $grade->id }}" {{ old('salary_grade_id', $employee->salary_grade_id) == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                                @endforeach
                            </select>
                            @error('salary_grade_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="shift_plan_id" class="block text-sm font-medium text-gray-700">Shift Plan</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('shift_plan_id') border-red-500 @enderror" id="shift_plan_id" name="shift_plan_id">
                                <option value="">Select Shift Plan</option>
                                @foreach($shiftPlans as $shift)
                                    <option value="{{ $shift->id }}" {{ old('shift_plan_id', $employee->shift_plan_id) == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                @endforeach
                            </select>
                            @error('shift_plan_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="leave_rule_id" class="block text-sm font-medium text-gray-700">Leave Rule</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('leave_rule_id') border-red-500 @enderror" id="leave_rule_id" name="leave_rule_id">
                                <option value="">Select Leave Rule</option>
                                @foreach($leaveRules as $rule)
                                    <option value="{{ $rule->id }}" {{ old('leave_rule_id', $employee->leave_rule_id) == $rule->id ? 'selected' : '' }}>{{ $rule->name }}</option>
                                @endforeach
                            </select>
                            @error('leave_rule_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                         <div class="md:col-span-1">
                            <label for="attendance_rule" class="block text-sm font-medium text-gray-700">Attendance Rule</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('attendance_rule') border-red-500 @enderror" id="attendance_rule" name="attendance_rule">
                                <option value="">Select Attendance Rule</option>
                                @foreach($attendanceRules as $rule)
                                    <option value="{{ $rule->id }}" {{ old('attendance_rule', $employee->attendance_rule) == $rule->id ? 'selected' : '' }}>{{ $rule->name }}</option>
                                @endforeach
                            </select>
                            @error('attendance_rule')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="employment_nature" class="block text-sm font-medium text-gray-700">Employment Nature</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('employment_nature') border-red-500 @enderror" id="employment_nature" name="employment_nature">
                                <option value="">Select Nature</option>
                                <option value="Permanent" {{ old('employment_nature', $employee->employment_nature) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                <option value="Temporary" {{ old('employment_nature', $employee->employment_nature) == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="Provision" {{ old('employment_nature', $employee->employment_nature) == 'Provision' ? 'selected' : '' }}>Provision</option>
                                <option value="Contractual" {{ old('employment_nature', $employee->employment_nature) == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                            </select>
                            @error('employment_nature')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="weekend_rule_ids" class="block text-sm font-medium text-gray-700">Weekend Rules</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('weekend_rule_ids') border-red-500 @enderror" id="weekend_rule_ids" name="weekend_rule_ids[]" multiple>
                                @foreach($weekendRules as $rule)
                                    {{-- Check if the rule's ID is in the employee's assigned weekend rules --}}
                                    <option value="{{ $rule->id }}" {{ in_array($rule->id, old('weekend_rule_ids', $employee->weekendRules->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $rule->name }}</option>
                                @endforeach
                            </select>
                            @error('weekend_rule_ids')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label for="reporting_func_id" class="block text-sm font-medium text-gray-700">Reporting Functional</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('reporting_func_id') border-red-500 @enderror" id="reporting_func_id" name="reporting_func_id">
                                <option value="">Select Employee</option>
                                @foreach($employeesList as $emp)
                                    <option value="{{ $emp->id }}" {{ old('reporting_func_id', $employee->reporting_func_id) == $emp->id ? 'selected' : '' }}>{{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_id }})</option>
                                @endforeach
                            </select>
                            @error('reporting_func_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="reporting_admin_id" class="block text-sm font-medium text-gray-700">Reporting Admin</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('reporting_admin_id') border-red-500 @enderror" id="reporting_admin_id" name="reporting_admin_id">
                                <option value="">Select Employee</option>
                                @foreach($employeesList as $emp)
                                    <option value="{{ $emp->id }}" {{ old('reporting_admin_id', $employee->reporting_admin_id) == $emp->id ? 'selected' : '' }}>{{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_id }})</option>
                                @endforeach
                            </select>
                            @error('reporting_admin_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Bank Information Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Bank Information</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank Name</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('bank_id') border-red-500 @enderror" id="bank_id" name="bank_id">
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id', $employee->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="bank_branch_id" class="block text-sm font-medium text-gray-700">Branch Name</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('bank_branch_id') border-red-500 @enderror" id="bank_branch_id" name="bank_branch_id">
                                <option value="">Select Branch</option>
                                @foreach($bankBranches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('bank_branch_id', $employee->bank_branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_branch_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('account_number') border-red-500 @enderror" id="account_number" name="account_number" value="{{ old('account_number', $employee->account_number) }}">
                            @error('account_number')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Entitlements & Self Service Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Entitlement</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-x-6 gap-y-4">
                        {{-- Row 1: Overtime, Holiday Bonus, Off Day Overtime --}}
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="ent_overtime" name="ent_overtime" value="1" {{ old('ent_overtime', $employee->ent_overtime) ? 'checked' : '' }}>
                                <label for="ent_overtime" class="ml-2 block text-sm text-gray-900">Overtime</label>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="ent_bonus" name="ent_bonus" value="1" {{ old('ent_bonus', $employee->ent_bonus) ? 'checked' : '' }}>
                                <label for="ent_bonus" class="ml-2 block text-sm text-gray-900">Holiday Bonus</label>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="ent_offday_ot" name="ent_offday_ot" value="1" {{ old('ent_offday_ot', $employee->ent_offday_ot) ? 'checked' : '' }}>
                                <label for="ent_offday_ot" class="ml-2 block text-sm text-gray-900">Off Day Overtime</label>
                            </div>
                        </div>
                        <div class="col-span-1"></div>
                        <div class="col-span-1"></div>
                        <div class="col-span-1"></div>

                        {{-- Row 2: Provident Fund, Provident Fund Date, Provident Fund Account No. --}}
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="ent_pf" name="ent_pf" value="1" {{ old('ent_pf', $employee->ent_pf) ? 'checked' : '' }}>
                                <label for="ent_pf" class="ml-2 block text-sm text-gray-900">Provident Fund</label>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="provident_fund_date" class="block text-sm font-medium text-gray-700">Provident Fund Date</label>
                            <div class="relative">
                                <input type="text" class="datepicker mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('provident_fund_date') border-red-500 @enderror" id="provident_fund_date" name="provident_fund_date" value="{{ old('provident_fund_date', $employee->provident_fund_date ? \Carbon\Carbon::parse($employee->provident_fund_date)->format('m/d/Y') : '') }}" placeholder="mm/dd/yyyy">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            @error('provident_fund_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="provident_fund_account_no" class="block text-sm font-medium text-gray-700">Provident Fund Account No.</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('provident_fund_account_no') border-red-500 @enderror" id="provident_fund_account_no" name="provident_fund_account_no" value="{{ old('provident_fund_account_no', $employee->provident_fund_account_no) }}">
                            @error('provident_fund_account_no')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2"></div>

                        {{-- Row 3: Insurance, Insurance Dropdown, Insurance Account, Insurance Type, Insurance Amount --}}
                        <div class="col-span-1">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="ent_insurance" name="ent_insurance" value="1" {{ old('ent_insurance', $employee->ent_insurance) ? 'checked' : '' }}>
                                <label for="ent_insurance" class="ml-2 block text-sm text-gray-900">Insurance</label>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="insurance_id" class="block text-sm font-medium text-gray-700">Insurance</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('insurance_id') border-red-500 @enderror" id="insurance_id" name="insurance_id">
                                <option value="">Select One</option>
                                @foreach($insurances as $insurance)
                                    <option value="{{ $insurance->id }}" {{ old('insurance_id', $employee->insurance_id) == $insurance->id ? 'selected' : '' }}>{{ $insurance->name }}</option>
                                @endforeach
                            </select>
                            @error('insurance_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="insurance_account" class="block text-sm font-medium text-gray-700">Insurance Account</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('insurance_account') border-red-500 @enderror" id="insurance_account" name="insurance_account" value="{{ old('insurance_account', $employee->insurance_account) }}">
                            @error('insurance_account')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="insurance_type" class="block text-sm font-medium text-gray-700">Insurance Type</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('insurance_type') border-red-500 @enderror" id="insurance_type" name="insurance_type" value="{{ old('insurance_type', $employee->insurance_type) }}">
                            @error('insurance_type')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="insurance_amount" class="block text-sm font-medium text-gray-700">Insurance Amount</label>
                            <input type="number" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('insurance_amount') border-red-500 @enderror" id="insurance_amount" name="insurance_amount" value="{{ old('insurance_amount', $employee->insurance_amount) }}">
                            @error('insurance_amount')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Previous Service Record in the Company --}}
                        <div class="col-span-full">
                            <div class="border-b pb-3 mb-3 mt-4">
                                <h5 class="text-lg font-medium text-gray-800">Previous Service Record in the Company</h5>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <div class="flex items-center mt-3">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="consider_service_length" name="consider_service_length" value="1" {{ old('consider_service_length', $employee->consider_service_length) ? 'checked' : '' }}>
                                <label for="consider_service_length" class="ml-2 block text-sm text-gray-900">Consider the service length</label>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="service_length" class="block text-sm font-medium text-gray-700">Service Length</label>
                            <input type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('service_length') border-red-500 @enderror" id="service_length" name="service_length" value="{{ old('service_length', $employee->service_length) }}">
                            @error('service_length')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="service_length_unit" class="block text-sm font-medium text-gray-700">Month/Year</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('service_length_unit') border-red-500 @enderror" id="service_length_unit" name="service_length_unit">
                                <option value="">--Select One--</option>
                                <option value="Month" {{ old('service_length_unit', $employee->service_length_unit) == 'Month' ? 'selected' : '' }}>Month</option>
                                <option value="Year" {{ old('service_length_unit', $employee->service_length_unit) == 'Year' ? 'selected' : '' }}>Year</option>
                            </select>
                            @error('service_length_unit')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-1"></div>

                        {{-- Self Service Section --}}
                        <div class="col-span-full">
                            <div class="border-b pb-3 mb-3 mt-4">
                                <h5 class="text-lg font-medium text-gray-800">Self Service</h5>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="self_service" name="self_service" value="1" {{ old('self_service', $employee->self_service) ? 'checked' : '' }}>
                                <label for="self_service" class="ml-2 block text-sm text-gray-900">Activate Self Service</label>
                            </div>
                        </div>

                        {{-- Login Information Section (Visibility Toggled by Self Service Access) --}}
                        <div id="login_information_section" class="col-span-full grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-1">
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('username') border-red-500 @enderror" id="username" name="username" value="{{ old('username', $employee->user->email ?? '') }}">
                                @error('username')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                                <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('password') border-red-500 @enderror" id="password" name="password">
                                @error('password')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-1">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" id="password_confirmation" name="password_confirmation">
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Password fields are only for changing the password. Leave them blank to keep the existing one.</p>
                        </div>

                    </div>
                </div>

                {{-- Educational Information Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Educational Information</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="institute_name" class="block text-sm font-medium text-gray-700">Institute Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('institute_name') border-red-500 @enderror" id="institute_name" name="institute_name" value="{{ old('institute_name', $employee->institute_name) }}">
                            @error('institute_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="exam_name" class="block text-sm font-medium text-gray-700">Exam Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('exam_name') border-red-500 @enderror" id="exam_name" name="exam_name" value="{{ old('exam_name', $employee->exam_name) }}">
                            @error('exam_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="authority_name" class="block text-sm font-medium text-gray-700">Authority Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('authority_name') border-red-500 @enderror" id="authority_name" name="authority_name" value="{{ old('authority_name', $employee->authority_name) }}">
                            @error('authority_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="exam_level" class="block text-sm font-medium text-gray-700">Exam Level</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('exam_level') border-red-500 @enderror" id="exam_level" name="exam_level" value="{{ old('exam_level', $employee->exam_level) }}">
                            @error('exam_level')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="course_duration" class="block text-sm font-medium text-gray-700">Course Duration (Years)</label>
                            <input type="number" step="0.1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('course_duration') border-red-500 @enderror" id="course_duration" name="course_duration" value="{{ old('course_duration', $employee->course_duration) }}" min="0">
                            @error('course_duration')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="exam_year" class="block text-sm font-medium text-gray-700">Exam Year</label>
                            <input type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('exam_year') border-red-500 @enderror" id="exam_year" name="exam_year" value="{{ old('exam_year', $employee->exam_year) }}" min="1900" max="{{ date('Y') + 5 }}">
                            @error('exam_year')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="major" class="block text-sm font-medium text-gray-700">Major/Group</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('major') border-red-500 @enderror" id="major" name="major" value="{{ old('major', $employee->major) }}">
                            @error('major')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="certificate_number" class="block text-sm font-medium text-gray-700">Certificate Number</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('certificate_number') border-red-500 @enderror" id="certificate_number" name="certificate_number" value="{{ old('certificate_number', $employee->certificate_number) }}">
                            @error('certificate_number')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="cgpa" class="block text-sm font-medium text-gray-700">CGPA</label>
                            <input type="number" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('cgpa') border-red-500 @enderror" id="cgpa" name="cgpa" value="{{ old('cgpa', $employee->cgpa) }}" min="0" max="5">
                            @error('cgpa')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="mark_avail" class="block text-sm font-medium text-gray-700">Mark Available</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('mark_avail') border-red-500 @enderror" id="mark_avail" name="mark_avail">
                                <option value="">Select</option>
                                <option value="Yes" {{ old('mark_avail', $employee->mark_avail) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('mark_avail', $employee->mark_avail) == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('mark_avail')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="total_mark" class="block text-sm font-medium text-gray-700">Total Mark</label>
                            <input type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('total_mark') border-red-500 @enderror" id="total_mark" name="total_mark" value="{{ old('total_mark', $employee->total_mark) }}" min="0">
                            @error('total_mark')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Employee Experiences Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">Employee Experiences</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('company_name') border-red-500 @enderror" id="company_name" name="company_name" value="{{ old('company_name', $employee->company_name) }}">
                            @error('company_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="designation_experience" class="block text-sm font-medium text-gray-700">Designation</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('designation_experience') border-red-500 @enderror" id="designation_experience" name="designation_experience" value="{{ old('designation_experience', $employee->designation_experience) }}">
                            @error('designation_experience')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="country_experience" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('country_experience') border-red-500 @enderror" id="country_experience" name="country_experience" value="{{ old('country_experience', $employee->country_experience) }}">
                            @error('country_experience')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="city_experience" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('city_experience') border-red-500 @enderror" id="city_experience" name="city_experience" value="{{ old('city_experience', $employee->city_experience) }}">
                            @error('city_experience')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-full">
                            <label for="address_experience" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('address_experience') border-red-500 @enderror" id="address_experience" name="address_experience" value="{{ old('address_experience', $employee->address_experience) }}">
                            @error('address_experience')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="start_date_experience" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <div class="relative">
                                <input type="text" class="datepicker mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('start_date_experience') border-red-500 @enderror" id="start_date_experience" name="start_date_experience" value="{{ old('start_date_experience', $employee->start_date_experience ? \Carbon\Carbon::parse($employee->start_date_experience)->format('m/d/Y') : '') }}" placeholder="mm/dd/yyyy">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            @error('start_date_experience')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="end_date_experience" class="block text-sm font-medium text-gray-700">End Date</label>
                            <div class="relative">
                                <input type="text" class="datepicker mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('end_date_experience') border-red-500 @enderror" id="end_date_experience" name="end_date_experience" value="{{ old('end_date_experience', $employee->end_date_experience ? \Carbon\Carbon::parse($employee->end_date_experience)->format('m/d/Y') : '') }}" placeholder="mm/dd/yyyy">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            @error('end_date_experience')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('currency') border-red-500 @enderror" id="currency" name="currency" value="{{ old('currency', $employee->currency) }}">
                            @error('currency')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="start_salary" class="block text-sm font-medium text-gray-700">Start Salary</label>
                            <input type="number" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('start_salary') border-red-500 @enderror" id="start_salary" name="start_salary" value="{{ old('start_salary', $employee->start_salary) }}" min="0">
                            @error('start_salary')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <label for="end_salary" class="block text-sm font-medium text-gray-700">End Salary</label>
                            <input type="number" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('end_salary') border-red-500 @enderror" id="end_salary" name="end_salary" value="{{ old('end_salary', $employee->end_salary) }}" min="0">
                            @error('end_salary')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-full">
                            <label for="responsibilities" class="block text-sm font-medium text-gray-700">Responsibilities</label>
                            <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('responsibilities') border-red-500 @enderror" id="responsibilities" name="responsibilities" rows="3">{{ old('responsibilities', $employee->responsibilities) }}</textarea>
                            @error('responsibilities')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- User Documents Section --}}
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="border-b pb-3 mb-3">
                        <h5 class="text-lg font-medium text-gray-800">User Documents</h5>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <label for="file_name" class="block text-sm font-medium text-gray-700">Document Name</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('file_name') border-red-500 @enderror" id="file_name" name="file_name" value="{{ old('file_name', $employee->file_name) }}">
                            @error('file_name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="achievement_date" class="block text-sm font-medium text-gray-700">Achievement Date</label>
                            <div class="relative">
                                <input type="text" class="datepicker mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-1.5 px-2.5 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm @error('achievement_date') border-red-500 @enderror" id="achievement_date" name="achievement_date" value="{{ old('achievement_date', $employee->achievement_date ? \Carbon\Carbon::parse($employee->achievement_date)->format('m/d/Y') : '') }}" placeholder="mm/dd/yyyy">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            @error('achievement_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="file_path" class="block text-sm font-medium text-gray-700">Upload Document</label>
                            <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('file_path') border-red-500 @enderror" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.txt,.xlsx,.csv">
                            @error('file_path')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Max 5MB. Allowed types: PDF, DOC, DOCX, TXT, XLSX, CSV.</p>
                            @if ($employee->file_path)
                                <p class="mt-1 text-xs text-gray-600">Current Document: <a href="{{ asset('storage/employee_documents/' . $employee->file_path) }}" target="_blank" class="text-blue-500 hover:underline">{{ $employee->file_name ?? $employee->file_path }}</a></p>
                                <div class="flex items-center mt-1">
                                    <input type="checkbox" id="remove_current_document" name="remove_current_document" value="1" class="h-4 w-4 text-red-600">
                                    <label for="remove_current_document" class="ml-2 text-sm text-gray-700">Remove current document</label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-x-3 mt-5">
                    <button type="submit" class="inline-flex justify-center py-1 px-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                    <a href="{{ route('employees.index') }}" class="inline-flex justify-center py-1 px-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "m/d/Y",
                altInput: true,
                altFormat: "F j, Y",
            });

            // Photo Preview Logic
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photo-preview');
            const removePhotoBtn = document.getElementById('remove-photo-btn');
            const defaultPhotoSrc = "{{ asset('storage/employee_photos/no-photo.png') }}";

            // If there's an existing photo and user doesn't upload a new one, clicking "remove" should just clear the path
            // For editing, if no new file is selected, the old path should persist unless remove is checked.

            photoInput.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        removePhotoBtn.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(event.target.files[0]);
                } else {
                    // If file input cleared, but no new file picked, revert to existing photo or default
                    // This is tricky. If they had a photo and clicked "change" but cancelled, we want the old photo to stay.
                    // The backend handles the existing photo if no new one is uploaded.
                    // This part only affects the *preview* if they click cancel on file dialog.
                    if ("{{ $employee->photo_path }}" !== '') {
                        photoPreview.src = "{{ asset('storage/employee_photos/' . $employee->photo_path) }}";
                        removePhotoBtn.style.display = 'inline-block';
                    } else {
                        photoPreview.src = defaultPhotoSrc;
                        removePhotoBtn.style.display = 'none';
                    }
                }
            });

            removePhotoBtn.addEventListener('click', function() {
                photoPreview.src = defaultPhotoSrc;
                photoInput.value = ''; // Clear the input file for submission
                removePhotoBtn.style.display = 'none';
                // Add a hidden input to signal backend to remove the photo if no new one is uploaded
                const hiddenRemovePhotoInput = document.createElement('input');
                hiddenRemovePhotoInput.type = 'hidden';
                hiddenRemovePhotoInput.name = 'remove_photo';
                hiddenRemovePhotoInput.value = '1';
                document.querySelector('form').appendChild(hiddenRemovePhotoInput);
            });


            // "Same as Present Address" Checkbox Logic
            const sameAsPresentAddressCheckbox = document.getElementById('same_as_present_address');
            const presentAddressFields = [
                'present_address', 'present_po', 'present_ps', 'present_zip',
                'present_district', 'present_upazila_id', 'present_country'
            ];
            const permanentAddressFields = [
                'permanent_address', 'permanent_po', 'permanent_ps', 'permanent_zip',
                'permanent_district', 'permanent_upazila_id', 'permanent_country'
            ];

            function syncAddresses() {
                if (sameAsPresentAddressCheckbox.checked) {
                    presentAddressFields.forEach((fieldId, index) => {
                        const presentField = document.getElementById(fieldId);
                        const permanentField = document.getElementById(permanentAddressFields[index]);

                        if (permanentField && presentField) {
                            permanentField.value = presentField.value;
                            permanentField.disabled = true;
                            permanentField.classList.add('bg-gray-100');
                            if (permanentField.tagName === 'SELECT') {
                                permanentField.dispatchEvent(new Event('change'));
                            }
                        }
                    });
                } else {
                    permanentAddressFields.forEach(fieldId => {
                        const permanentField = document.getElementById(fieldId);
                        if (permanentField) {
                            // Don't clear value here on uncheck if it contained existing data
                            // Only re-enable and remove disabled style
                            permanentField.disabled = false;
                            permanentField.classList.remove('bg-gray-100');
                            if (permanentField.tagName === 'SELECT') {
                                permanentField.dispatchEvent(new Event('change'));
                            }
                        }
                    });
                }
            }

            sameAsPresentAddressCheckbox.addEventListener('change', syncAddresses);

            // Listen to changes on present address fields to update permanent if synced
            presentAddressFields.forEach(fieldId => {
                const presentField = document.getElementById(fieldId);
                if (presentField) {
                    presentField.addEventListener('input', syncAddresses);
                    if (presentField.tagName === 'SELECT') {
                        presentField.addEventListener('change', syncAddresses);
                    }
                }
            });

            // Initial sync on page load for address
            syncAddresses();


            // Self Service Access checkbox to toggle Login Information section
            const selfServiceCheckbox = document.getElementById('self_service');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const loginInfoFields = [usernameInput, passwordInput, passwordConfirmationInput];

            function toggleLoginInfoSection() {
                if (selfServiceCheckbox.checked) {
                    loginInfoFields.forEach(field => {
                        field.disabled = false;
                        field.classList.remove('bg-gray-100');
                    });
                    // If enabling and no old username, try to pre-fill with existing employee ID/email
                    // This is more for creation; for edit, it's already pre-filled from $employee->user->email
                    if (!usernameInput.value) {
                         // Potentially pre-fill with something logical like employee_id if not already set
                         // usernameInput.value = "{{ $employee->employee_id }}@yourdomain.com"; // Example
                    }
                } else {
                    loginInfoFields.forEach(field => {
                        field.value = ''; // Clear value
                        field.disabled = true;
                        field.classList.add('bg-gray-100');
                    });
                }
            }
            selfServiceCheckbox.addEventListener('change', toggleLoginInfoSection);
            toggleLoginInfoSection(); // Initial state on page load


            // Provident Fund checkbox to toggle associated fields
            const entPfCheckbox = document.getElementById('ent_pf');
            const providentFundDateInput = document.getElementById('provident_fund_date');
            const providentFundAccountNoInput = document.getElementById('provident_fund_account_no');
            const providentFundFields = [providentFundDateInput, providentFundAccountNoInput];

            function toggleProvidentFundFields() {
                if (entPfCheckbox.checked) {
                    providentFundFields.forEach(field => {
                        field.disabled = false;
                        field.classList.remove('bg-gray-100');
                    });
                } else {
                    providentFundFields.forEach(field => {
                        field.value = '';
                        field.disabled = true;
                        field.classList.add('bg-gray-100');
                    });
                }
            }
            entPfCheckbox.addEventListener('change', toggleProvidentFundFields);
            toggleProvidentFundFields(); // Initial state on page load


            // Insurance checkbox to toggle associated fields
            const entInsuranceCheckbox = document.getElementById('ent_insurance');
            const insuranceIdSelect = document.getElementById('insurance_id');
            const insuranceAccountInput = document.getElementById('insurance_account');
            const insuranceTypeInput = document.getElementById('insurance_type');
            const insuranceAmountInput = document.getElementById('insurance_amount');
            const insuranceFields = [insuranceIdSelect, insuranceAccountInput, insuranceTypeInput, insuranceAmountInput];

            function toggleInsuranceFields() {
                if (entInsuranceCheckbox.checked) {
                    insuranceFields.forEach(field => {
                        field.disabled = false;
                        field.classList.remove('bg-gray-100');
                    });
                } else {
                    insuranceFields.forEach(field => {
                        field.value = '';
                        field.disabled = true;
                        field.classList.add('bg-gray-100');
                    });
                }
            }
            entInsuranceCheckbox.addEventListener('change', toggleInsuranceFields);
            toggleInsuranceFields(); // Initial state on page load


            // Consider Service Length checkbox to toggle associated fields
            const considerServiceLengthCheckbox = document.getElementById('consider_service_length');
            const serviceLengthInput = document.getElementById('service_length');
            const serviceLengthUnitSelect = document.getElementById('service_length_unit');
            const serviceLengthFields = [serviceLengthInput, serviceLengthUnitSelect];

            function toggleServiceLengthFields() {
                if (considerServiceLengthCheckbox.checked) {
                    serviceLengthFields.forEach(field => {
                        field.disabled = false;
                        field.classList.remove('bg-gray-100');
                    });
                } else {
                    serviceLengthFields.forEach(field => {
                        field.value = '';
                        field.disabled = true;
                        field.classList.add('bg-gray-100');
                    });
                }
            }
            considerServiceLengthCheckbox.addEventListener('change', toggleServiceLengthFields);
            toggleServiceLengthFields(); // Initial state on page load

        });
    </script>
@endsection