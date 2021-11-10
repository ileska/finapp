<p><a href="#" onclick="document.getElementById('logout').submit(); return false">logout</a></p>
<p>Hello <span>$name</span> !</p>
<p>Your balance - <span>$balance</span></p>
<br>
<form action="/withdraw" method="POST">
	<label>Withdraw</label><br/>
	<input type="number" name="amount"><br/> <br/>
	<button>Withdraw</button>
</form>


<form id="logout" action="logout" method="POST"></form>