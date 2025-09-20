<div>
    {{-- <p>This is my first anonymous component as themode which is located in app.php </p> --}}
    <section>
        <div class="card">
    <h5 class="card-header">{{ $title }}</h5>

    <div class="card-body">
@if($slot->isEmpty())
    <p style="color:red;">Provide some content for slot!</p>
@else
    {{ $slot }}
@endif

    <div class="card-footer">
        {{ $footer }}
    </div>
</div>


    </section>
</div>
