@include('template.header')  
<form action="{{ route('listFactureImpaye') }}" method="post">
@csrf

    <div class="container-fluid py-4">

      <div class="row mt-9 d-flex justify-content-center align-items-center">

        <div class="col-lg-4 mb-lg-0 mb-4">
          <div class="card">

            <div class="card-body p-4">

              <div class="row d-flex justify-content-center align-items-center">

                <div class="col-lg-11 mb-3">
                  <label class="form-control-label">Client</label>
                  <select class="form-control" name="idclient" id="idclient">
                      @foreach ($clients as $client)
                          <option value="{{$client->idclient}}"> {{$client->nom}} </option>
                      @endforeach
                  </select>
                </div>

                <div class="col-lg-11">
                  <label class="form-control-label">Lieu</label>
                  <select class="form-control" name="idlieu">
                      @foreach ($lieux as $lieu)
                          <option value="{{$lieu->idlieu}}"> {{$lieu->nom}} </option>
                      @endforeach
                  </select>
                </div>

              </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center pt-4 ps-4 pb-4 pe-4">
              <div class="col-lg-6 text-center">
                <button type="submit" class="btn bg-gradient-primary w-100 mb-0">Entrer </button>
              </div>
            </div>
            
          </div>

          <script>
            
            document.getElementById('idclient').addEventListener('change', function () {
                const clientId = this.value;
                fetch('/getlieuxbyidclient?clientId=' + clientId)
                    .then(response => response.json())
                    .then(data => {
                        updateLieuxSelect(data.lieux);
                    })
                    .catch(error => console.error('Erreur:', error));
            });

            function updateLieuxSelect(lieux) {
                const lieuSelect = document.querySelector('.form-control[name="idlieu"]');
                lieuSelect.innerHTML = '';
                lieux.forEach(function (lieu) {
                    const option = new Option(lieu.nom, lieu.idlieu);
                    lieuSelect.add(option);
                });
            }

          </script>

        </div>

      </div>
    
</form>
@include('template.footer')