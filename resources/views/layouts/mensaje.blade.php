@if(Session::has("m"))
<br/>
<br/>
    <diV class="alert alert-{{Session::get('m')['clase']}}">
        <button type="button" class="close" data-dimiss ="alert" aria-hidden="true"> &times;</button>
        <strong>{{ Session::get("m")["msj"]}}</strong>
    </div>
<br/>
@endif