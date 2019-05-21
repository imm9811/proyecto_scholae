
      <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <h1>Panel de Control</h1>

        <section class="row text-center placeholders">
          <div class="col-6 col-sm-4 placeholder">
         <button id="añadirAdministrador" class="añadirObject"><i class="fa fa-cloud-upload"></i>
            <h4>Añadir</h4>
            </button>
          </div>
          <div class="col-6 col-sm-4 placeholder">
         <button id="listarAdministrador" class="listarObject"><i class="fa fa-book"></i>
            <h4>Listar</h4>
            </button>
          </div>
         
          
        </section>
        <div id="controladorListar" class="listar mostrar ">
          <?php
            include 'listarCategorias.php';
          ?>
        </div>
        <div id="controladorAñadir" class="añadir ocultar">
          <?php
            include 'addCategorias.php';
          ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>
