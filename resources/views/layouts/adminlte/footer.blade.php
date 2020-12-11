<footer class="main-footer">
    {{-- <div class="float-right d-none d-sm-block">
      <b>Version</b> 0.1
    </div> --}}
    <strong>
      Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} 
      <a href="{{ config('app.url') }}">{{ config('app.name', 'Laravel') }}</a>.
    </strong>
    All rights reserved.
</footer>