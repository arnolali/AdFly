<?php 
	include 'configs/global.php';
?>
<!DOCTYPE html>
<!--[if lt IE 8]> <html class="lt-ie10 lt-ie9 lt-ie8" lang="<?= $culture ?>"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie10 lt-ie9" lang="<?= $culture ?>"> <![endif]-->
<!--[if IE 9]>    <html class="lt-ie10" lang="<?= $culture ?>"> <![endif]-->
<!--[if gt IE 9]><!--><html lang="<?= $culture ?>"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?= $t['form']; ?> | Les Incontournables du voyage </title>
	<meta name="description" property="og:description" content="Outils de création publicitaire pour les annonceurs de La Presse+." />
	<meta name="author" content="Jonathan Harvey, Simon Arnold" />
	<meta property="og:type" content="website"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="shortcut icon" href="<?= URL ?>public/images/favicon.ico"/>
	<link rel="stylesheet" media="all" href="<?= URL ?>public/styles/form.css">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body class="no1">
	<header class="main-header">
		<a href="<?= $t['creationKitLink']; ?>">
			<img src="http://plus.lapresse.ca/cdn/img/LaPressePlus.svg" class="logo">
		</a>
		<div class="title">
			<h2><?= $t['generalData']; ?></h2>
			<h2><?= $t['offers']; ?></h2>
			<h2><?= $t['preview']; ?></h2>
		</div>
		<?php if($culture == 'fr') { ?>
			<a href="<?= URL ?>en" title="<?= $t['changeLanguage']; ?>" class="action lang"></a>
		<?php } else { ?>
			<a href="<?= URL ?>fr" title="<?= $t['changeLanguage']; ?>" class="action lang"></a>
		<?php } ?>
		<form method="post" action="app/libraries/uploadZip.php" class="action import" title="<?= $t['importAd']; ?>" enctype="multipart/form-data" autocomplete="off">
			<span class="icon"></span>
			<input type="file" name="adzip" class="js-import-ad" />
		</form>

		<? if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) { 
    		$safari = 'Safari'; 
		} ?>
	</header>

	<form method="post" action="ad.php" enctype="multipart/form-data" autocomplete="off" class="js-form form">
		<input type="hidden" name="id" />
		<input type="hidden" name="offersId" />
		<div class="steps">
			<!-- === Step 1 ================================================= -->
			<section class="step no1">
				<div class="content">
					<fieldset class="created">
						<div class="row">
							<div class="half field">
								<label>
									<span class="lbl"><?= $t['clientNo']; ?></span><br>
									<input type="text" name="noClient" class="input short js-validate" placeholder="Nom du client" required/>
								</label>
							</div>

							<div class="half field">
								<label>
									<span class="lbl"><?= $t['adNo']; ?></span><br>
									<input type="text" name="noAd" class="input short opt js-validate" placeholder="1234567" />
								</label>
							</div>
						</div>

						<div class="row">
							<div class="half field">
								<label>
									<span class="lbl"><?= $t['category']; ?></span><br>
									<select name="category" class="select short js-validate" required>
										<option value="deals"><?= $t['deals']; ?></option>
										<option value="conferences"><?= $t['conferences']; ?></option>
										<option value="cruise"><?= $t['cruise']; ?></option>
										<option value="adventures"><?= $t['adventures']; ?></option>
										<option value="escapades"><?= $t['escapades']; ?></option>
										<option value="circuits"><?= $t['circuits']; ?></option>
										<option value="packages"><?= $t['packages']; ?></option>
										<option value="destinationWorld"><?= $t['destinationWorld']; ?></option>
									</select>
									<input type="hidden" name="previousChoice" value="deals"/>
								</label>
							</div>

							<div class="half field logo">
								<input type="hidden" name="pre-logo">
								<label>
									<span class="lbl">Logo</span><br>
									<div class="btn blue file">
										<span class="text"><?= $t['uploadImage']; ?></span>
										<input type="file" accept="image/*" capture="camera" name="logo" class="file-input js-validate" required>
									</div>
									<span class="preview"></span>
								</label>
							</div>
						</div>

						<div class="row field format">
							<label class="lbl"><?= $t['format']; ?></label><br>
							<input type="radio" name="format" value="480x325" checked />
							<input type="radio" name="format" value="480x152" />
							<input type="radio" name="format" value="230x325" />
							<input type="radio" name="format" value="230x152" />
						</div>
					</fieldset>

					<footer class="footer">
						<div class="btn blue rgt js-nextStep js-goStep2"><?= $t['next']; ?></div>
					</footer>
				</div>
			</section>

			<!-- === Step 2 ================================================= -->
			<section class="step no2">
				<div class="content">
					<header class="header">
						<input name="offersNbr" type="hidden" value="0" />
						<a href="#" class="btn rgt addOffer"><?= $t['addOffer']; ?></a>
						<span class="addOfferMsg"></span>
					</header>
					<div class="offersList">
						<!-- public/templates/offer-tpl.mustache.html -->
					</div>

					<footer class="footer">
						<div class="btn lft js-previousStep js-goStep1"><?= $t['previous']; ?></div>
						<div class="btn blue rgt js-nextStep js-goStep3"><?= $t['next']; ?></div>
					</footer>
				</div>
			</section>

			<!-- === Step 3 ================================================= -->
			<section class="step no3">
				<iframe class="zipable"></iframe>
				<div class="content">
					<div class="iframe">
						<iframe class="render"></iframe>
					</div>

					<footer class="footer">
						<div class="btn lft js-previousStep js-goStep2"><?= $t['previous']; ?></div>
						<div class="btn blue rgt js-download disabled"><?= $t['download']; ?></div>
						<label>
							<input type="checkbox" name="iConfirm">
							<span>
								<?= $t['iConfirm']; ?>
							</span>
						</label>
					</footer>
				</div>

				<div class="popup confirmation">
					<div class="window">
						<span class="close js-cancel"></span>
						<h2><?= $t['confirmation']; ?></h2>
						<div class="text">
							<? if ($safari) { 
								 echo "<span style='color:rgba(255, 0, 0, 1)'>".$t[$culture]['zipMac']."</span>"; 
								 echo "<br><br>";
							} ?>
							<?= $t['confirmationText']; ?>
						</div>
						<label>
							<div class="btn lft js-cancel"><?= $t['cancel']; ?></div>
							<div class="btn blue rgt js-confirm"><?= $t['download']; ?></div>
						</label>
					</div>
				</div>

				<div class="popup delete">
					<div class="window">
						<span class="close js-cancel"></span>
						<h2><?= $t['confirmation']; ?></h2>
						<div class="text"></div>
						<label>
							<div class="btn lft js-cancel"><?= $t['cancel']; ?></div>
							<div class="btn blue rgt js-confirm"><?= $t['ok']; ?></div>
						</label>
					</div>
				</div>

				<div class="popup error">
					<div class="window">
						<span class="close js-cancel"></span>
						<h2><?= $t['error']; ?></h2>
						<div class="text"></div>
					</div>
				</div>

			</section>
		</div>
	</form>

	<footer class="main-footer">
		<div class="legend">
			<span class="color opt"></span> <?= $t['optionalFields']; ?>
		</div>
		<a href="<?= $t['creationKitLink']; ?>" class="return"><?= $t['returnToTheCreationKit']; ?></a>
	</footer>

	<div class="ad-drop-zone">
		<form method="post" action="app/libraries/uploadZip.php" class="action import" title="<?= $t['importAd']; ?>" enctype="multipart/form-data" autocomplete="off">
			<input type="file" name="adzip" class="js-import-ad" />
		</form>
		<span class="ad-drop-zone__close"><?= $t['close']; ?></span>
	</div>

	<script src="<?= URL ?>public/scripts/plugins.min.js"></script>
	<script src="<?= URL ?>public/scripts/form.min.js"></script>
	<script>
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-38205796-4']);
		_gaq.push(['_trackPageview']);
	    (function(){ 
	      var ga = document.createElement('script'); 
	      ga.type = 'text/javascript'; 
	      ga.async = true; 
	      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; 
	      var s = document.getElementsByTagName('script')[0]; 
	      s.parentNode.insertBefore(ga, s); }
	    )();
		$(document).ready(function() {
          _g = new app("<?= $culture ?>", "<?= URL ?>");
        });
	</script>
</body>
</html>