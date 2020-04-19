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
            <label for="delayed_minutes">Минути на закъснение</label>
            <input type="text" style="width: 100px" class="form-control" name="delayed_minutes" id='delayed_minutes'
                   value=""> минути<br>
            <span id="warn_delay" style="color: red"></span>
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
          enableSeconds: true,
          minuteIncrement: 1,
          onClose: function (selectedDates, dateStr, instance) {
              $('#delayed_minutes').val(getMinutesBetweenDates(dateStr));
          },
      })

        // Todo add setTimeDelay()

      // function setTimeDelay() {
      //     let departure = new Date($('#departure_at').val());
      //
      //     let add_minutes = departure.setMinutes(departure.getMinutes() + $('#delayed_minutes').val());
      //     $('#delayed_at').val(new Date(add_minutes));
      //
      //     //const fp = flatpickr("#delayed_at", {});
      //     //const myInput = $('#delayed_minutes').val();
      //     //const fp = flatpickr(myInput, {});  // flatpickr
      //
      // }

      window.addEventListener('load', () => {
          let d = $('#delayed_at');

          if(d.val()) {
              let delay = new Date(d.val());
              let departure = new Date($('#departure_at').val());

              let diff = (delay.getTime() - departure.getTime()) / 1000;
              diff /= 60;

              $('#delayed_minutes').val(Math.abs(Math.round(diff)));
          }
      });

      function getMinutesBetweenDates(delayed) {
          let delay = new Date(delayed);
          let departure = new Date($('#departure_at').val());

          let diff = (delay.getTime() - departure.getTime()) / 1000;
          diff /= 60;

          if(Math.sign(diff) > 0) { //check positive minutes
              return Math.abs(Math.round(diff));
          } else {
              $('#warn_delay').text('Моля, въведете по-късен час.');
          }
      }
  </script>
@endsection

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
