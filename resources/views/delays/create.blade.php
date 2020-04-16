@extends('layouts.app')

@section('content')
<div class="card card-default">
  <div class="card-header">
    {{ isset($delay) ? 'Редактирай закъснение': 'Създай закъснение' }}
  </div>

  <div class="card-body">
    @include('partials.errors')
    <form action="{{ isset($delay) ? route('delays.update', $delay->id) : route('delays.store') }}" method="POST">
      @csrf

      @if(isset($delay))
        @method('PUT')
      @endif

        <div class="form-group">
            <label for="from">От посока</label>
            <select name="from" id="from" class="form-control" disabled>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                        @if(isset($delay))
                            @if($city->id === $delay->from_id)
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
            <select name="to" id="to" class="form-control" disabled>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                        @if(isset($delay))
                            @if($city->id === $delay->to_id)
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
            <label for="departure_at">Заминава</label>
            <input disabled type="text" class="form-control" name="departure_at" id='departure_at' value="{{ isset($delay) ? $delay->departure_at : '' }}">
        </div>

        <div class="form-group">
            <label for="delayed_at">Задай час на закъснение</label>
            <input type="text" class="form-control" name="delayed_at" id='delayed_at'
                   value="{{ isset($delay) ? $delay->delayed_at : '' }}">
        </div>

        <div class="form-group">
            <label for="delayed_minutes">Или задай минути на закъснение</label>
            <input type="text" style="width: 100px" class="form-control" name="delayed_minutes" id='delayed_minutes'
                   value="">
        </div>

        <input type="hidden" name="id" value="{{ isset($delay) ? $delay->id : '' }}">

      <div class="form-group">
        <button type="submit" class="btn btn-success">
          {{ isset($delay) ? 'Обнови закъснение': 'Създай закъснение' }}
        </button>
          <a class="btn btn-default btn-info" href="{{ route('delays.index') }}">Откажи</a>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr('#delayed_at', {
        //noCalendar: true,
        //dateFormat: "H:i",
      enableTime: true,
      enableSeconds: true
    })
  </script>

  <script>
  $('#delayed_minutes').val(999);

  function getMinutesBetweenDates(startDate, endDate) {
      let diff = Math.abs(new Date(endDate) - new Date(startDate));
      return Math.floor((diff/1000)/60);
  }

  </script>


@endsection

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection