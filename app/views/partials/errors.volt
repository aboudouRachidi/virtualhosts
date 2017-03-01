
{% if msg is defined %}
<div class="ui icon error  message">
  <i class="warning circle icon"></i>
  <div class="content">
    <div class="header">
		Erreur !
    </div>
   
      <p>{{  msg }}</p>
	<br>
{#     {{ q["btnAdd"] }}#}
{#     {{ q["btnCancel"] }}#}
  </div>
</div>
{% endif %}