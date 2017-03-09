<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card-2 w3-round w3-white">
        <div class="w3-container">
         <p class="w3-center"><i class="fa fa-user fa-4x" alt="Avatar"></i></p>
         <h4 class="w3-center">{{ user.getName() ~' '~ user.getFirstname()}}</h4>
         <hr>
         <p><i class="fa fa-id-badge fa-fw w3-margin-right w3-text-theme"></i>{{ user.getLogin() }}</p>
         <p><i class="fa fa-envelope-o fa-fw w3-margin-right w3-text-theme"></i>{{ user.getEmail() }}</p>
        </div>
      </div>
      <br>
      
            <!-- Accordion -->
      <div class="w3-card-2 w3-round">
        <div class="w3-white">
           {{ q["btEditProfile"] }}
           
           {{ q["btEditPassword"] }}
        </div>      
      </div>
      <br>
      
      <!-- VIRTUALHOSTS --> 
      <div class="w3-card-2 w3-round w3-white w3-hide-small">
        <div class="w3-container">
          <p>Virtualhosts</p>
          <p>
            <span class="w3-tag w3-small w3-theme-d3">Virtualhosts 1</span>
            <span class="w3-tag w3-small w3-theme-d2">Virtualhosts 2</span>
            <span class="w3-tag w3-small w3-theme-d1">Virtualhosts 3</span>
            <span class="w3-tag w3-small w3-theme">Virtualhosts 4</span>
            <span class="w3-tag w3-small w3-theme-l1">Virtualhosts 5</span>
            <span class="w3-tag w3-small w3-theme-l2">Virtualhosts 6</span>

          </p>
        </div>
      </div>
      <br>
      
      <!-- Alert Box -->
      <div class="w3-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-hover-text-grey w3-closebtn">
          <i class="fa fa-remove"></i>
        </span>
        <p><strong>Bienvenue dans votre espace client !</strong></p>
        <p>Bonne navigation.</p>
      </div>
    
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <div class="w3-col m7">
    
      <div class="w3-row-padding">
      <div id="refresh">
            <div class="w3-col m12 middle-column">
                <div class="w3-card-4">
                
                <header class="w3-container w3-light-grey">
                  <h3>Test des échanges client/serveur</h3>
                </header>
                
                <div class="w3-container">
                  <p>....</p>
                  <hr>
                  <p>...</p>
                </div>
                
                <button class="w3-button w3-block w3-dark-grey">{{ q["lbl"] }}</button>
                
                </div> 
            </div>
        </div>
      </div>
      
      
    <!-- End Middle Column -->
    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2">
      <div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
          <p>Hosts :</p>
          <i class="fa fa-hdd-o fa-4x" aria-hidden="true"></i>
          <p><strong>Machine...</strong></p>
          <p>12-01-2016</p>
          <p><button class="w3-button w3-block w3-theme-l4">Info</button></p>
        </div>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-padding-16 w3-center">
        <p>ADS</p>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-padding-32 w3-center">
        <p><i class="fa fa-bug w3-xxlarge"></i></p>
      </div>
      
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>