<?php
if (isset($_GET['run'])) {
  shell_exec("sudo su -");
  shell_exec("sudo apt-get -y update && sudo apt-get -y upgrade");
  shell_exec("cd /var/www/");
  shell_exec("sudo rm -r html");
  shell_exec("sudo wget -q  https://github.com/DestroyerAlpha/MilestoneIndustries/archive/develop.zip");
  shell_exec("sudo  unzip -o -q *.zip && sudo rm -f *.zip");
  shell_exec("sudo mv -f MilestoneIndustries-develop/ html/");
  shell_exec("cd ~");
  header('Location: http://mynewprojectwebsite.cf/');
}
?>
<a href="?run=true">Click </a>
to update this website to latest github developer version.
If everythings goes well, you will automatically be redirected to the home page of latest version of website.