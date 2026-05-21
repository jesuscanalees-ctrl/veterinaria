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
                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-10 position-relative">
                                <div class="input-group input-group-lg shadow-sm">
                                    <input type="text" id="buscador-expedientes" class="form-control border-left-primary" placeholder="Buscar por nombre de mascota, dueño o folio..." aria-label="Buscar expediente" autocomplete="off">
                                </div>
                                <div id="resultados-busqueda" class="list-group position-absolute shadow text-left" style="z-index: 1000; display:none; top: 100%; left: 15px; right: 15px;"></div>
                            </div>
                        </div>

                        {{-- Mascota seleccionada --}}
                        <div id="mascota-seleccionada-card" class="row justify-content-center mb-3" style="display:none !important;">
                            <div class="col-md-10">
                                <div class="alert alert-primary d-flex align-items-center justify-content-between py-2 px-3 shadow-sm" style="border-radius: 10px;">
                                    <div class="text-left">
                                        <strong><i class="fas fa-paw mr-2"></i><span id="mascota-nombre-seleccionada"></span></strong>
                                        <span class="text-muted ml-2" style="font-size:0.85rem;">Dueño: <span id="mascota-dueno-seleccionada"></span></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-primary badge-pill mr-3">Folio: <span id="mascota-id-seleccionada"></span></span>
                                        <button type="button" id="btn-limpiar-seleccion" class="btn btn-sm btn-outline-secondary py-0 px-2" title="Quitar selección">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="mt-3">
                            <button id="btn-ver-consultas" class="btn btn-info mx-2 mb-2 px-4 shadow-sm" disabled title="Selecciona una mascota primero">
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
            const inputBuscador        = document.getElementById('buscador-expedientes');
            const contenedorResultados = document.getElementById('resultados-busqueda');
            const cardSeleccionada     = document.getElementById('mascota-seleccionada-card');
            const spanNombre           = document.getElementById('mascota-nombre-seleccionada');
            const spanDueno            = document.getElementById('mascota-dueno-seleccionada');
            const spanId               = document.getElementById('mascota-id-seleccionada');
            const btnVerConsultas      = document.getElementById('btn-ver-consultas');
            const btnLimpiar           = document.getElementById('btn-limpiar-seleccion');

            let mascotaSeleccionadaId  = null;
            let timeout = null;

            // ── Buscar ──────────────────────────────────────────────────────────
            inputBuscador.addEventListener('input', function(e) {
                clearTimeout(timeout);
                const query = e.target.value.trim();

                if (query.length < 1) {
                    contenedorResultados.style.display = 'none';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/expedientes/buscar?query=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                        .then(data => {
                            contenedorResultados.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(mascota => {
                                    const item = document.createElement('a');
                                    item.href = 'javascript:void(0)';
                                    item.className = 'list-group-item list-group-item-action border-left-primary';
                                    item.dataset.id     = mascota.id;
                                    item.dataset.nombre = mascota.nombre;
                                    item.dataset.dueno  = mascota.dueno_nombre;
                                    item.innerHTML = `
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <h6 class="mb-0 font-weight-bold text-gray-800"><i class="fas fa-paw text-primary mr-2"></i>${mascota.nombre}</h6>
                                            <span class="badge badge-primary badge-pill">Folio: ${mascota.id}</span>
                                        </div>
                                        <p class="mb-0 mt-1 text-sm text-gray-600"><i class="fas fa-user text-gray-400 mr-2"></i>Dueño: ${mascota.dueno_nombre}</p>
                                    `;
                                    item.addEventListener('click', () => seleccionarMascota(mascota));
                                    contenedorResultados.appendChild(item);
                                });
                                contenedorResultados.style.display = 'block';
                            } else {
                                contenedorResultados.innerHTML = '<div class="list-group-item text-muted text-center py-3"><i class="fas fa-info-circle mr-2"></i>No se encontraron coincidencias</div>';
                                contenedorResultados.style.display = 'block';
                            }
                        })
                        .catch(err => console.error('Error en la búsqueda:', err));
                }, 300);
            });

            // ── Seleccionar mascota ──────────────────────────────────────────────
            function seleccionarMascota(mascota) {
                mascotaSeleccionadaId = mascota.id;

                spanNombre.textContent = mascota.nombre;
                spanDueno.textContent  = mascota.dueno_nombre;
                spanId.textContent     = mascota.id;

                // Mostrar tarjeta de selección
                cardSeleccionada.style.display = 'flex';
                cardSeleccionada.style.removeProperty('display');   // quitar !important override
                cardSeleccionada.classList.remove('d-none');
                cardSeleccionada.style.display = '';                // deja que Bootstrap lo maneje
                cardSeleccionada.removeAttribute('style');          // limpiar inline
                cardSeleccionada.style.display = 'flex';

                // Habilitar botón
                btnVerConsultas.disabled = false;
                btnVerConsultas.title    = '';

                // Ocultar dropdown
                contenedorResultados.style.display = 'none';
                inputBuscador.value = mascota.nombre + ' — ' + mascota.dueno_nombre;
            }

            // ── Limpiar selección ────────────────────────────────────────────────
            btnLimpiar.addEventListener('click', function() {
                limpiarSeleccion();
            });

            function limpiarSeleccion() {
                mascotaSeleccionadaId = null;
                cardSeleccionada.style.display = 'none';
                btnVerConsultas.disabled = true;
                btnVerConsultas.title    = 'Selecciona una mascota primero';
                inputBuscador.value = '';
                contenedorResultados.style.display = 'none';
                contenedorResultados.innerHTML = '';
            }

            // ── Ver Consultas ────────────────────────────────────────────────────
            btnVerConsultas.addEventListener('click', function() {
                if (mascotaSeleccionadaId) {
                    window.location.href = `/mascotas/${mascotaSeleccionadaId}/consultas`;
                }
            });

            // ── Ocultar resultados fuera del buscador ────────────────────────────
            document.addEventListener('click', function(e) {
                if (!inputBuscador.contains(e.target) && !contenedorResultados.contains(e.target)) {
                    contenedorResultados.style.display = 'none';
                }
            });

            // ── Volver a mostrar al enfocar ──────────────────────────────────────
            inputBuscador.addEventListener('focus', function(e) {
                if (e.target.value.trim().length > 0 && contenedorResultados.innerHTML !== '') {
                    contenedorResultados.style.display = 'block';
                }
            });
        });
    </script>
@endsection
