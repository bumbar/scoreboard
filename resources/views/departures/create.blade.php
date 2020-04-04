@extends('layouts.app')

@section('content')
<div class="card card-default">
  <div class="card-header">
    {{ isset($departure) ? 'Редактирай заминаващ': 'Създай заминаващ' }}
  </div>

  <div class="card-body">
    @include('partials.errors')
    <form action="{{ isset($departure) ? route('departures.update', $departure->id) : route('departures.store') }}" method="POST">
      @csrf

      @if(isset($departure))
        @method('PUT')
      @endif

        <div class="form-group">
            <label for="from">От посока</label>
            <select name="from" id="from" class="form-control">
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                        @if(isset($departure))
                            @if($city->id === $departure->from_id)
                                selected
                            @endif
                        @endif
                    >
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="to">В посока</label>
            <select name="to" id="to" class="form-control">
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                        @if(isset($departure))
                            @if($city->id === $departure->to_id)
                                selected
                            @endif
                        @endif
                    >
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="places">Места</label>
            <input type="text" name="places" id="places" class="form-control" style="width: 100px" value="{{ isset($departure) ? $departure->places : '' }}">
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="text" name="price" id="price" class="form-control" style="width: 100px" value="{{ isset($departure) ? $departure->price : '' }}">
        </div>

      <div class="form-group">
        <label for="departure_at">Задай час</label>
        <input type="text" class="form-control" name="departure_at" id='departure_at' value="{{ isset($departure) ? $departure->departure_at : '' }}">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success">
          {{ isset($departure) ? 'Обнови заминаващ': 'Създай заминаващ' }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr('#departure_at', {
      enableTime: true,
      enableSeconds: true
    })
  </script>
@endsection

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
