@extends('layouts.app')

@section('content')
    <style>
        .selected {
            background-color: #cce5ff !important;
        }

        tr {
            cursor: pointer;
        }
    </style>

<div x-data="{
    selectedIndex: null,
    select(index) {
        this.selectedIndex = index;
    }
}">
    <table  border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="(row, index) in [
                { id: 1, name: 'Alice' },
                { id: 2, name: 'Bob' },
                { id: 3, name: 'Charlie' }
            ]" :key="index">
                <tr
                    :class="{ 'selected': selectedIndex === index }"
                    @click="select(index)"
                >
                    <td x-text="row.id"></td>
                    <td x-text="row.name"></td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
