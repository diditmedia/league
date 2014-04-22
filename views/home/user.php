<h1><?= $user->getUsername() ?></h1>

<p>
	name: <?= $user->getFirstName() ?> <?= $user->getLastName() ?>

</p>

<p>
	email: <?= $user->getEmail() ?>
</p>

<input type="range" id="score" min="0" max="14" step="0" value="0" orient="vertical" style="-webkit-appearance: slider-vertical; writing-mode: bt-lr;" list="score">

<output for="score"></output>

<datalist id="volsettings">
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option>14</option>
</datalist>