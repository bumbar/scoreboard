@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
  <a href="{{ route('departures.create') }}" class="btn btn-success">Добави Курс</a>
</div>

<div class="card card-default">
  <div class="card-header">Разписание</div>

  <div class="card-body">

    @if($departures->count() > 0)
          <table class="table">
              <thead>
              <th>От</th>
              <th>До</th>
              <th>Заминаване</th>
              <th></th>
              <th></th>
              </thead>
              <tbody>
              @foreach($departures as $departure)
                  <tr>
                      <td>
                          {{ $departure->cityFrom->name }}
                      </td>
                      <td>
                          {{ $departure->cityTo->name }}
                      </td>
                      <td>
                          {{ \Carbon\Carbon::parse($departure->departure_at)->format('j F, Y h:i:s A') }}
                      </td>
                      @if($departure->trashed())
                          <td>
                              <form action="{{ route('restore-departures', $departure->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <button type="submit" class="btn btn-info btn-sm">Възстанови</button>
                              </form>
                          </td>
                      @else
                          <td>
                              <a href="{{ route('departures.edit', $departure) }}" class="btn btn-info btn-sm">Редактирай</a>
                          </td>
                      @endif
                      <td>
                          <form action="{{ route('departures.destroy', $departure->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">
                                  {{ $departure->trashed() ? 'Delete': 'Trash' }}
                              </button>
                          </form>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
    @else
      <h3 class="text-center">Няма изтрити курсове.</h3>
    @endif
  </div>
    {{ $departures->appends(['cities' => request()->query('cities') ])->links() }}
</div>
@endsection
