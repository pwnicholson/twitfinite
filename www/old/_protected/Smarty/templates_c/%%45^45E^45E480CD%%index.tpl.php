<?php /* Smarty version 2.6.18, created on 2010-09-19 00:50:52
         compiled from index.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title><?php echo $this->_tpl_vars['site_name']; ?>
 | <?php echo $this->_tpl_vars['title']; ?>
</title>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['root']; ?>
_js/prototype.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['root']; ?>
_js/functions.js"></script>
<link rel="icon" type="image/png" href="<?php echo $this->_tpl_vars['root']; ?>
images/Parrot-small.png" />
<link href="<?php echo $this->_tpl_vars['root']; ?>
_css/calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['root']; ?>
_css/blueprint/screen.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['root']; ?>
_css/blueprint/print.css" type="text/css" media="print" />
<!--[if IE]><link rel="stylesheet" href="_css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<link href="<?php echo $this->_tpl_vars['root']; ?>
_css/stylesheet.css?t=<?php echo $this->_tpl_vars['css_time']; ?>
" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['root']; ?>
_css/navlist-vert.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['root']; ?>
_css/navlist-hor.css" rel="stylesheet" type="text/css" />

<script language="javascript">
var root = '<?php echo $this->_tpl_vars['root']; ?>
';
</script>

<meta name="description" content="ReTweetBot: A better way to have a conversation!" />
</head>
<body<?php if ($this->_tpl_vars['onload']): ?> onload="<?php echo $this->_tpl_vars['onload']; ?>
"<?php endif; ?>>

<div id="content">
	<a href="<?php echo $this->_tpl_vars['root']; ?>
home"><div id="header"><span>A better way to have a conversation!</span></div></a>
	
	<div class="container">
		<div class="span-24 last">
			<div class="span-5">
				<div id="navcontainer">
				<?php if ($this->_tpl_vars['user_id']): ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/retweet/nav.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php else: ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/home/nav.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php endif; ?>
				</div>
				
				<div style="margin-right: 25px; margin-left: 25px;">
					<script type="text/javascript"><!--
					google_ad_client = "pub-6686761318058414";
					/* 120x240, created 2/28/09 */
					google_ad_slot = "7053245261";
					google_ad_width = 120;
					google_ad_height = 240;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div>
			</div>
	
			<div id="bd" class="span-19 last">
			<?php if ($this->_tpl_vars['url'][0] == 'bot' && $this->_tpl_vars['url'][1] != 'add'): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/bot/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['include']): ?>
			<?php if ($this->_tpl_vars['title_alt']): ?>
			<div class="title"><?php echo $this->_tpl_vars['title_alt']; ?>
</div>
			<?php elseif ($this->_tpl_vars['title']): ?>
			<div class="title"><?php echo $this->_tpl_vars['title']; ?>
</div>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['err'] && $this->_tpl_vars['url'][1] != 'login'): ?>
			<p>
			<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['err']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
				<div class="err"><?php echo $this->_tpl_vars['err'][$this->_sections['a']['index']]; ?>
</div>
			<?php endfor; endif; ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['msg']): ?>
			<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['msg']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
				<div class="msg"><?php echo $this->_tpl_vars['msg'][$this->_sections['a']['index']]; ?>
</div>
			<?php endfor; endif; ?>
			</p>
			<?php endif; ?>
			<div class="container">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['include']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<?php endif; ?>
			</div>
		
		</div>
	</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if (! $this->_tpl_vars['dev']): ?>
<script type="text/javascript">
<?php echo '
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2876312-6");
pageTracker._trackPageview();
} catch(err) {}
'; ?>

</script>
<?php endif; ?>

</body>
</html>