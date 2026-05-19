@extends('layouts/main')

@section('titulo_pagina', 'Expedientes')
@section('hide_sidebar', true)

@section('content')
    <div class="container-fluid mt-4">
        <h3 class="text-gray-800 mb-4">Gestión de Expedientes</h3>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-gray-300 mb-4"></i>
                        <h5 class="text-gray-600 font-weight-bold mb-4">Buscar Expediente de Paciente</h5>
                        
                        {{-- Buscador --}}
                        <div class="form-group row justify-content-center mb-4">
                            <div class="col-md-10 position-relative">
                                <div class="input-group input-group-lg shadow-sm">
                                    <input type="text" id="buscador-expedientes" class="form-control border-left-primary" placeholder="Buscar por nombre de mascota, dueño o folio..." aria-label="Buscar expediente" autocomplete="off">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                <div id="resultados-busqueda" class="list-group position-absolute shadow text-left" style="z-index: 1000; display:none; top: 100%; left: 15px; right: 15px;"></div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="mt-4">
                            <button class="btn btn-info mx-2 mb-2 px-4 shadow-sm">
                                <i class="fas fa-stethoscope mr-1"></i> Ver Consultas
                            </button>
                            <button class="btn btn-success mx-2 mb-2 px-4 shadow-sm">
                                <i class="fas fa-plus-circle mr-1"></i> Crear Nuevo Paciente / Mascota
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputBuscador = document.getElementById('buscador-expedientes');
            const contenedorResultados = document.getElementById('resultados-busqueda');
            let timeout = null;

            inputBuscador.addEventListener('input', function(e) {
                clearTimeout(timeout);
                const query = e.target.value.trim();

                if (query.length < 1) {
                    contenedorResultados.style.display = 'none';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/expedientes/buscar?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            contenedorResultados.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(mascota => {
                                    const item = document.createElement('a');
                                    item.href = 'javascript:void(0)'; // Prevenir recarga
                                    item.className = 'list-group-item list-group-item-action border-left-primary';
                                    item.innerHTML = `
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <h6 class="mb-0 font-weight-bold text-gray-800"><i class="fas fa-paw text-primary mr-2"></i>${mascota.nombre}</h6>
                                            <span class="badge badge-primary badge-pill">Folio: ${mascota.id}</span>
                                        </div>
                                        <p class="mb-0 mt-1 text-sm text-gray-600"><i class="fas fa-user text-gray-400 mr-2"></i>Dueño: ${mascota.dueno_nombre}</p>
                                    `;
                                    contenedorResultados.appendChild(item);
                                });
                                contenedorResultados.style.display = 'block';
                            } else {
                                contenedorResultados.innerHTML = '<div class="list-group-item text-muted text-center py-3"><i class="fas fa-info-circle mr-2"></i>No se encontraron coincidencias</div>';
                                contenedorResultados.style.display = 'block';
                            }
                        })
                        .catch(error => console.error('Error en la búsqueda:', error));
                }, 300);
            });

            // Ocultar resultados si se hace clic fuera del buscador
            document.addEventListener('click', function(e) {
                if (!inputBuscador.contains(e.target) && !contenedorResultados.contains(e.target)) {
                    contenedorResultados.style.display = 'none';
                }
            });
            
            // Volver a mostrar resultados al hacer clic en el input si hay texto
            inputBuscador.addEventListener('focus', function(e) {
                 if(e.target.value.trim().length > 0 && contenedorResultados.innerHTML !== '') {
                     contenedorResultados.style.display = 'block';
                 }
            });
        });
    </script>
@endsection
