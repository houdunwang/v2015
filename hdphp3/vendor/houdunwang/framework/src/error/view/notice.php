<div style="border: 1px solid #990000;padding-left: 20px;margin: 10px;font-family: Monaco,Menlo,Consolas,monospace;">
	<h3 style="font-size: 18px;margin: 20px 0;"><?php echo $error; ?></h3>
	<p style="font-size: 14px;margin: 15px 0;">
		Severity: <?php echo $this->errorType( $errno ); ?>
	</p>
	<p>
		File: <?php echo $file; ?>
	</p>
	<p>
		Line: <?php echo $line; ?>
	</p>
</div>

<div>
	<?php foreach ( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) as $id => $f ): ?>
		<?php if ( isset( $f['file'] ) ): ?>
			<li>
				#<?php echo $id + 1; ?> <?php echo $f['file']; ?>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
<style>
	body {
		background : #fefefe;
	}
</style>