@include('template.header')

    <div class="container-fluid py-4">

        <div class="row mt-6">
        <!-- <div class="row mt-2 d-flex justify-content-center align-items-center"> -->

            <div class="col-lg-3 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-center align-items-center text-uppercase">
                        <h6>Saisie Lieu</h6>
                    </div>
                    <form action="{{ route('saisieLieu') }}" method="post">
                        @csrf

                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="form-control-label">Lieu</label>
                                    <input type="text" class="form-control" name="nom">
                                </div>

                            </div>            

                        </div>

                        <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                            <div class="col-lg-6 text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">soumettre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-center align-items-center text-uppercase">
                        <h6>Saisie Entite Client</h6>
                    </div>
                    <form action="{{ route('saisieClient') }}" method="post">
                        @csrf

                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="form-control-label">Entite</label>
                                    <input type="text" class="form-control" name="nom">
                                </div>

                                <div class="col-lg-12">
                                    <label class="form-control-label">NIF</label>
                                    <input type="text" class="form-control" name="nif">
                                </div>

                                <div class="col-lg-12">
                                    <label class="form-control-label">STAT</label>
                                    <input type="text" class="form-control" name="stat">
                                </div>

                            </div>            

                        </div>

                        <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                            <div class="col-lg-6 text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">soumettre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-3 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-center align-items-center text-uppercase">
                        <h6>Saisie Information Client</h6>
                    </div>
                    <form action="{{ route('saisieInfoClient') }}" method="post">
                        @csrf

                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="form-control-label">Entite</label>
                                    <select class="form-control" name="idclient" id="idclient">
                                        @foreach ($clients as $client)
                                            <option value="{{$client->idclient}}"> {{$client->nom}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <label class="form-control-label">Lieu</label>
                                    <select class="form-control" name="idlieu">
                                        @foreach ($lieux as $lieu)
                                            <option value="{{$lieu->idlieu}}"> {{$lieu->nom}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <label class="form-control-label">Nom</label>
                                    <input type="text" class="form-control" name="entite">
                                </div>

                            </div>            

                        </div>

                        <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                            <div class="col-lg-6 text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">soumettre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>

    </div>

@include('template.footer')
