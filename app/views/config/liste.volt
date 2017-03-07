</br>
<h4 class="ui dividing header">Liste des virtualhosts pour la machine {{ machine.getName() }}</h4>

{{ q["table"] }}


{% if host != "rien" %}<!-- 4 -->
{% for server in servers %}<!-- 1 -->
<form action="{{ url("Config/RebootServ") }}" class="ui form" method="POST" name='redemarerServ' id='redemarerServ'>
<h4 class="ui dividing header">{{ server.getName() }}: 
<input type="hidden" name ="server" value="{{ server.getId() }}">
<button class="mini ui button" ><i class="power icon"></i>Redémarer le serveur</button> 
</h4>
</form>
<div class="ui middle aligned divided list">
{% for virtualhost in virtualhosts %}<!-- 2 -->
{% if virtualhost.getIdServer() == server.getId() %}<!-- 3 -->
  <div class="item">
   <form action="{{ url("Config/Reboot") }}" class="ui form" method="POST" name='redemarerVH' id='redemarerVH'>
    <div class="right floated content">
    <input type="hidden" name ="virtualhost" value="{{ virtualhost.getId() }}">
      <button class="mini ui button" ><i class="power icon"></i>Valider et redémarer le service</div>
     <i class="disk outline icon"></i>
      </button>        
    <div class="content">
    </form>
      {{ virtualhost.getName() }}
    </div>
  </div>
{% endif %}<!-- 3 -->
{% endfor %}<!-- 2 -->
</div>
{% endfor %}<!-- 1 -->
{% endif %}<!-- 4 -->


{% if host == "rien" %}
<div class="ui middle aligned divided list">
{% for virtualhost in virtualhosts %}<!-- 2 -->
{% if virtualhost.getIdUser() == user.getId() %}<!-- 3 -->
  <div class="item">
  <form action="{{ url("Config/Reboot") }}" class="ui form" method="POST"  name='redemarerVH' id='redemarer' id='redemarerVH'>
    <div class="right floated content">
    <input type="hidden" name ="virtualhost" value="{{ virtualhost.getId() }}">
      <button class="mini ui button" ><i class="power icon"></i>Valider et redémarer le service</div>
      <i class="disk outline icon"></i>
      </button>
    <div class="content">
    </form>
      {{ virtualhost.getName() }}
    </div>
  </div>
{% endif %}<!-- 3 -->
{% endfor %}<!-- 2 -->
</div>
{% endif %}
