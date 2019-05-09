
      <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <h1>Panel de Control</h1>

        <section class="row text-center placeholders">
          <div class="col-6 col-sm-4 placeholder">
         <button onclick="añadirPlataforma()"><i class="fa fa-cloud-upload" style="font-size:150px"></i>
            <h4>Añadir</h4>
            </button>
          </div>
          <div class="col-6 col-sm-4 placeholder">
         <button id="listarPlataforma"><i class="fa fa-book" style="font-size:150px"></i>
            <h4>Listar</h4>
            </button>
          </div>
         
          
        </section>
        <div id="controladorListar" class="mostrar">
          <?php
            include 'listarPlataformas.php';
          ?>
        </div>
        <div id="controladorAñadir" class="mostrar">
          <?php
            include 'añadirPlataformas.php';
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
