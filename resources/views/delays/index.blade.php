@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">Закъснения</div>
        <div class="card-body">
            <table class="table">
                <thead>
                <th>От</th>
                <th>До</th>
                <th>Заминаване</th>
                <th>Закъснение</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                @foreach($delays as $delay)
                    <tr>
                        <td>
                            {{ $delay->cityFrom->name }}
                        </td>
                        <td>
                            {{ $delay->cityTo->name }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($delay->departure_at)->format('j F, Y H:i:s') }}
                        </td>
                        <td>
                            @if(is_null($delay->delayed_at))
                                ---
                            @else
                            <span style="color: red">{{ \Carbon\Carbon::parse($delay->delayed_at)->format('j F, Y H:i:s') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('delays.edit', $delay) }}" class="btn btn-info btn-sm">Редактирай</a>
                        </td>
                        <td>
                            <form action="{{ route('delays.destroy', $delay->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ isset($delay) ? $delay->id : '' }}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Изтрий
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
