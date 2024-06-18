<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="grid grid-cols-1 gap-4 lg:col-span-2">
        <div class="app-plate">
            <div class="flex flex-col lg:flex-row lg:justify-between">
                <div class="mb-5">
                    <p class="text-xl capitalize" title='name'>{{$data['name']}}</p>
                    <p class="text-slate-700" title='username'>{{$data['username']}}</p>
                </div>
                @hasanyrole('municipal|national')
                <details class="dropdown">
                    <summary class="m-1 btn btn-success">Others</summary>
                    <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
                        <li><a href="/back/user/{{$data['id']}}/edit">Update Account</a></li>
                        <li><a href="/back/user_info/{{$data['id']}}/edit">Update Info</a></li>
                    </ul>
                </details>
                @endhasanyrole
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 min-w-0">
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16v-5.5C11 8.5 9.4 7 7.5 7m3.5 9H4v-5.5C4 8.5 5.6 7 7.5 7m3.5 9v4M7.5 7H14m0 0V4h2.5M14 7v3m-3.5 6H20v-6a3 3 0 0 0-3-3m-2 9v4m-8-6.5h1" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['email']}}</p>
                        <p class="text-sm text-slate-700">Email</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 4a2.6 2.6 0 0 0-2 .9 6.2 6.2 0 0 0-1.8 6 12 12 0 0 0 3.4 5.5 12 12 0 0 0 5.6 3.4 6.2 6.2 0 0 0 6.6-2.7 2.6 2.6 0 0 0-.7-3L18 12.9a2.7 2.7 0 0 0-3.8 0l-.6.6a.8.8 0 0 1-1.1 0l-1.9-1.8a.8.8 0 0 1 0-1.2l.6-.6a2.7 2.7 0 0 0 0-3.8L10 4.9A2.6 2.6 0 0 0 8 4Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['contact_number']}}</p>
                        <p class="text-sm text-slate-700">Contact Number</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14c.6 0 1-.4 1-1V7c0-.6-.4-1-1-1H5a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Zm3-7h0v0h0v0Zm4 0h0v0h0v0Zm4 0h0v0h0v0Zm-8 4h0v0h0v0Zm4 0h0v0h0v0Zm4 0h0v0h0v0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{date("F j, Y",strtotime($data['birthday']))}}</p>
                        <p class="text-sm text-slate-700">Birthday</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 14v7M5 5v9.5c5.6-5.5 8.4 2.7 14 0V4.8c-5.6 2.7-8.4-5.5-14 0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="capitalize">{{$data['nationality']}}</p>
                        <p class="text-sm text-slate-700">nationality</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="capitalize">{{$data['civil_status']}}</p>
                        <p class="text-sm text-slate-700 ">Civil Status</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm2 4a3 3 0 0 0-3 2v.2c0 .1-.1.2 0 .2v.2c.3.2.6.4.9.4h6c.3 0 .6-.2.8-.4l.2-.2v-.2l-.1-.1A3 3 0 0 0 10 14H7.9Z" clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['voters_id']}} / {{$data['precinct'] ?? 'No Precinct'}}</p>
                        <p class="text-sm text-slate-700">Voters ID/Precinct No.</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="capitalize">{{$data['company_name']}}</p>
                        <p class="text-sm text-slate-700">Company Name</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4c0 1.1.9 2 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.8-3.1a5.5 5.5 0 0 0-2.8-6.3c.6-.4 1.3-.6 2-.6a3.5 3.5 0 0 1 .8 6.9Zm2.2 7.1h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1l-.5.8c1.9 1 3.1 3 3.1 5.2ZM4 7.5a3.5 3.5 0 0 1 5.5-2.9A5.5 5.5 0 0 0 6.7 11 3.5 3.5 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4c0 1.1.9 2 2 2h.5a6 6 0 0 1 3-5.2l-.4-.8Z" clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div class="pl-2">
                        <p class="capitalize">{{$data['company_position']}}</p>
                        <p class="text-sm text-slate-700">Company Position</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m8 10.9 7-3.2m-7 5.4 7 3.2M8 12a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm0-11a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['affiliations']}}</p>
                        <p class="text-sm text-slate-700">Affiliations</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.5 21h13M12 21V7m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm2-1.8c3 .7 2.5 2.8 5 2.8M5 8c3.4 0 2.2-2.1 5-2.8M7 9.6V7.8m0 1.8-2 4.3a.8.8 0 0 0 .4 1l.4.1h2.4a.8.8 0 0 0 .8-.7V14L7 9.6Zm10 0V7.3m0 2.3-2 4.3a.8.8 0 0 0 .4 1l.4.1h2.4a.8.8 0 0 0 .8-.7V14l-2-4.3Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['educational_attainment']}}</p>
                        <p class="text-sm text-slate-700">Education Attainment</p>
                    </div>
                </div>
                <div>
                    <div class="flex items-center mb-3">
                        <div>
                            <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M11 5.1a1 1 0 0 1 2 0l1.7 4c.1.4.4.6.8.6l4.5.4a1 1 0 0 1 .5 1.7l-3.3 2.8a1 1 0 0 0-.3 1l1 4a1 1 0 0 1-1.5 1.2l-3.9-2.3a1 1 0 0 0-1 0l-4 2.3a1 1 0 0 1-1.4-1.1l1-4.1c.1-.4 0-.8-.3-1l-3.3-2.8a1 1 0 0 1 .5-1.7l4.5-.4c.4 0 .7-.2.8-.6l1.8-4Z" />
                            </svg>
                        </div>
                        <div class="pl-2">
                            <p class="">{{$data['special_skills']}}</p>
                            <p class="text-sm text-slate-700">Special Skills</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center mb-3">
                        <div>
                            <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4c0 1.1.9 2 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.8-3.1a5.5 5.5 0 0 0-2.8-6.3c.6-.4 1.3-.6 2-.6a3.5 3.5 0 0 1 .8 6.9Zm2.2 7.1h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1l-.5.8c1.9 1 3.1 3 3.1 5.2ZM4 7.5a3.5 3.5 0 0 1 5.5-2.9A5.5 5.5 0 0 0 6.7 11 3.5 3.5 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4c0 1.1.9 2 2 2h.5a6 6 0 0 1 3-5.2l-.4-.8Z" clip-rule="evenodd" />
                            </svg>

                        </div>
                        <div class="pl-2">
                            <p class="capitalize">{{$data['sub_group_name']}}</p>
                            <p class="text-sm text-slate-700">Sub Group</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-start mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11.3 3.3a1 1 0 0 1 1.4 0l6 6 2 2a1 1 0 0 1-1.4 1.4l-.3-.3V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3c0 .6-.4 1-1 1H7a2 2 0 0 1-2-2v-6.6l-.3.3a1 1 0 0 1-1.4-1.4l2-2 6-6Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="pl-2 mt-1">
                        <p class="">{{$data['address']}}</p>
                        <p class="text-sm text-slate-700">Address</p>
                    </div>
                </div>

            </div>
            <div class="flex items-center">
                <h1 class="text-slate-700">Others</h1>
                <hr class="my-10 grow ml-5">
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 0 0-1 1v14c0 .6.4 1 1 1h18c.6 0 1-.4 1-1V5c0-.6-.4-1-1-1H3Zm4.3 5.7a1 1 0 0 1 1.4-1.4l3 3c.4.4.4 1 0 1.4l-3 3a1 1 0 0 1-1.4-1.4L9.6 12 7.3 9.7ZM13 14a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="capitalize">{{$data['role']}}</p>
                        <p class="text-sm text-slate-700">Role</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a9 9 0 0 0 5-1.5 4 4 0 0 0-4-3.5h-2a4 4 0 0 0-4 3.5 9 9 0 0 0 5 1.5Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="capitalize">{{$data['position']}}</p>
                        <p class="text-sm text-slate-700">Member Position</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M3 21h18M4 18h16M6 10v8m4-8v8m4-8v8m4-8v8M4 9.5v-1c0-.3.2-.6.5-.8l7-4.5a1 1 0 0 1 1 0l7 4.5c.3.2.5.5.5.8v1c0 .3-.2.5-.5.5h-15a.5.5 0 0 1-.5-.5Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['region']}}, {{$data['municipal']}}, {{$data['barangay']}}</p>
                        <p class="text-sm text-slate-700">Registry</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1c0 .6-.4 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['referrer'] ?? 'N/A'}}</p>
                        <p class="text-sm text-slate-700">Referrer</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.4 1.6a2 2 0 0 1 0 2.7l-6 6-3.4.7.7-3.4 6-6a2 2 0 0 1 2.7 0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['encoder'] ?? 'Self'}}</p>
                        <p class="text-sm text-slate-700">Encoder</p>
                    </div>
                </div>
                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11c.9 0 1.4-.5 2.2-1a33.3 33.3 0 0 0 4.5-5.8 1.5 1.5 0 0 1 2 .3 1.6 1.6 0 0 1 .4 1.3L14.7 10M7 11H4v6.5c0 .8.7 1.5 1.5 1.5v0c.8 0 1.5-.7 1.5-1.5V11Zm6.5-1h5l.5.1a1.8 1.8 0 0 1 1 1.4l-.1.9-2.1 6.4c-.3.7-.4 1.2-1.7 1.2-2.3 0-4.8-1-6.7-1.5" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['approver'] ?? 'N/A'}}</p>
                        <p class="text-sm text-slate-700">Approved By</p>
                    </div>
                </div>

                <div class="flex items-center mb-3">
                    <div>
                        <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1c0 .6-.4 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div class="pl-2">
                        <p class="">{{$data['endorsed_by'] ?? 'N/A'}}</p>
                        <p class="text-sm text-slate-700">Endorsed By</p>
                    </div>
                </div>
            </div>
            <hr class="mb-5">
            <div class="flex items-center mb-3">
                <div>
                    <svg class="w-8 h-8 text-slate-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 5V4c0-.6-.4-1-1-1H9a1 1 0 0 0-.8.3l-4 4a1 1 0 0 0-.2.6V20c0 .6.4 1 1 1h12c.6 0 1-.4 1-1v-5M9 3v4c0 .6-.4 1-1 1H4m11.4.8 2.7 2.7m1.2-3.9a2 2 0 0 1 0 3l-6.6 6.6L9 18l.7-3.7 6.7-6.7a2 2 0 0 1 3 0Z" />
                    </svg>
                </div>
                <div class="pl-2">
                    <p class="">{{$data['remarks'] ?? 'none'}}</p>
                    <p class="text-sm text-slate-700">Remarks</p>
                </div>
            </div>

        </div>
        <div class="w-full">
            <div class="grid grid-cols-2 gap-4">
                @foreach($valid_ids as $row)
                <?php
                $id_type = config("constants.valid_ids.{$row['type']}");
                ?>
                <div class=" bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="h-[200px] w-full overflow-hidden">
                        <a class='' id="valid-id-1h" href="{{$row['image']}}" data-lightbox="image-1" data-title="{{$id_type}}">
                            <img class="rounded-t-lg object-cover w-full h-full" src="{{$row['image']}}" alt="" />
                        </a>
                    </div>
                    <div class="p-3">
                        <p class="mb-0 font-normal text-gray-700 dark:text-gray-400">Type: {{$id_type}}</p>
                        <p class="mb-0 font-normal text-gray-700 dark:text-gray-400">No: {{$row['no']}}</p>
                    </div>
                </div>

                @endforeach
            </div>
        </div>

    </div>
    <div class="grid grid-cols-1 gap-4 min-w-0 h-fit">
        <div class="app-plate">
            <div class="h-full w-full">
                <a href="{{$data['profile']}}" data-lightbox="image-profile" data-title="{{$data['name']}}">
                    <img class="object-cover rounded-lg" src="{{$data['profile']}}" alt="">
                </a>
            </div>
        </div>
        @if($data['is_pending'])
        <div class="app-plate">
            <h1 class="text-lg mb-3">Review</h1>
            <form action="" id="main-form">
                <div class="mb-5">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <textarea class="input input-bordered w-full h-36" placeholder="Remarks" name="remarks" id=""></textarea>
                    <div>
                        <label class="hidden" for="">Action</label>
                        <select class="input input-bordered w-full " placeholder='action' name="action" id="" required>
                            <option value="">Select Action</option>
                            <option value="approve">Approve</option>
                            <option value="decline">Decline</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary fn-create-submit' type='submit'>
                        Confirm
                    </button>
                </div>
            </form>
        </div>
        @endif
        <div class="app-plate">
            <h1 class="text-lg mb-2">Activity Log</h1>
            <div class="grid grid-col-1 gap-2 mb-2">
                @foreach($logs as $log)
                <div class="bg-gray-100 p-2 rounded-lg">
                    <div class="">
                        {{$log['log']}}
                    </div>
                </div>
                @endforeach
            </div>
            <hr class="mt-5 mb-2">
            <div class="flex justify-end">
                <a href="/org/activity/{{$id}}" class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                    More Logs
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

</div>


<script>
    let ajax = new AjaxTools({
        target: "#main-form",
        rules: {},
        reset: true,
        ajax: (form) => {
            return {
                method: 'POST',
                url: `${BASE_URL}/back/user/review`,
                data: $(form).serialize(),
                cbSuccess: (e) => {
                    console.log(e);
                    location.reload();
                },
                cbError: (e) => {
                    console.log(e);
                }
            }
        }
    }).init();
</script>