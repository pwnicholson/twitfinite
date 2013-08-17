<?php /* Smarty version 2.6.18, created on 2010-09-19 00:50:52
         compiled from main/home/home.tpl */ ?>
<div class="span-19 last">
	<div style="float: right; margin-left: 10px; margin-right: 10px; width: 250px; height: 250px;">
		<object width="250" height="250"><param name="movie" value="http://widget.chipin.com/widget/id/dc85a47d8870d352"></param><param name="allowScriptAccess" value="always"></param><param name="wmode" value="transparent"></param><param name="event_title" value="ReTweetBot"></param><param name="event_desc" value="Contribute%20to%20RetweetBot%20and%20keep%20the%20service%20free%21"></param><param name="color_scheme" value="blue"></param><embed src="http://widget.chipin.com/widget/id/dc85a47d8870d352" flashVars="event_title=ReTweetBot&event_desc=Contribute%20to%20RetweetBot%20and%20keep%20the%20service%20free%21&color_scheme=blue" type="application/x-shockwave-flash" allowScriptAccess="always" wmode="transparent" width="250" height="250"></embed></object>
	</div>
	
	<div class="i">Please visit <a href="http://twitter.com/retweetbot" target="twitter">@ReTweetBot</a> on Twitter to see the full list.</div>
	
	<br/>
	
	<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['updates']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<?php echo $this->_tpl_vars['updates'][$this->_sections['a']['index']]['text']; ?>
<br/>
	<span class="twitter_ts"><?php echo $this->_tpl_vars['updates'][$this->_sections['a']['index']]['ts']; ?>
</span>
	<br/>
	<?php endfor; endif; ?>
</div>