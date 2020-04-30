<script src="{{ asset('build/app.js') }}"></script>
               {{ encore_entry_script_tags('app') }}
      <script src="{{ asset('build/runtime.js') }}"></script>
      {{ encore_entry_script_tags('app') }}




<link rel="stylesheet" href=" {{ asset('build/app.css') }}">

{{ encore_entry_link_tags('app') }}
        {{ encore_entry_link_tags('app') }}
                <link rel="stylesheet" href=" {{ encore_entry_link_tags('app') }}">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
        <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
        
        
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
  crossorigin="anonymous"></script>

  
       
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.js"
  integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA="
  crossorigin="anonymous"></script>





  
  

        {% for property in properties %}
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                         <h5 class="card-title">
                             <a href="{{path('property.show', {id:property.id, slug:property.slug })}}">{{property.title}}</a>
                    </h5>
                    <p class="card-text">
                             {{property.city}}</p>
                    <div class="text-primary">{{property.price|number_format(0,' ','')}}$</div>
                    </div>
                </div>
            </div>
            {% endfor %}



             <div id="app">
    <App />