@extends('layouts.main')
@section('content')

<div id="layoutSidenav_content">

    <div class="w-full px-6 py-10">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Transaction History</h1>

        {{-- Check if there are transactions --}}
        @if($transactions->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                No transactions found.
            </div>
        @else
            <div class="bg-white rounded-xl shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Amount</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ date('M d, Y H:i', strtotime($transaction->created_at)) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $transaction->category ? $transaction->category->name : 'Без категорії' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{$transaction->description }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold {{ $transaction->type == "spend"? 'text-red-500' : 'text-green-600' }}">
                                {{ $transaction->type == "spend" ? '-' : '+' }}${{ number_format(abs($transaction->amount), 2) }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
