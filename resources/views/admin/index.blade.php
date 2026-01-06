@extends('layouts.admin')

@section('content')
<div id="admin-app" class="flex h-screen overflow-hidden">
    @include('admin.sidebar')

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        @include('admin.header') {{-- Gọi file Header --}}

        <div id="content-area" class="flex-1 overflow-y-auto p-8">
            <div id="view-dashboard">
                @include('admin.dashboard', [
                    'articleCount' => $articleCount ?? 0,
                    'userCount' => $userCount ?? 0,
                    'commentCount' => $commentCount ?? 0,
                    'failedCount' => $failedCount ?? 0
                ])
            </div>

            <div id="view-articles" class="hidden">
                @include('admin.articles')
            </div>
            
            {{-- Các view khác... --}}
        </div>

        @include('admin.footer') {{-- Gọi file Footer --}}
    </main>
</div>
@endsection