<?php
	require_once("config.php");
	$states = array(
		0 => array(0, 1, 2, 3, 4), 			/* friesland */
		1 => array(1, 0, 2), 				/* groningen */
		2 => array(2, 0, 1, 5), 			/* drenthe */
		3 => array(3, 0, 4, 7, 8), 			/* noord-holland */
		4 => array(4, 0, 5, 6, 3, 7),	 	/* flevoland */
		5 => array(5, 6, 4, 2, 0), 			/* overijssel */
		6 => array(6, 5, 4, 7, 8, 10, 11), 	/* gelderland */
		7 => array(7, 3, 8, 5, 6), 			/* utrecht */
		8 => array(8, 9, 10, 6, 7, 3), 		/* zuid-holland */
		9 => array(9, 8, 10), 				/* zeeland */
		10 => array(10, 9, 8, 6, 11), 		/* noord-brabant */
		11 => array(11, 10, 6)				/* limburg */
	);
	
	
	$persons = "SELECT * FROM matches WHERE A = '".clean($person_id)."' OR B = '".clean($person_id)."'";
		if(!$result = $mysqli->query($persons)) {
		    trigger_error('Fout in query: '.$mysqli->error);
		} else {
			$list = array(); $score = array(); $f = 0;
			while($j = $result->fetch_array(MYSQLI_ASSOC)){
				if($j['match'] != 0){
					$list[$f]['A'] = $j['A'];
					$list[$f]['B'] = $j['B'];
					$list[$f]['match'] = $j['match'];
					$score[] = $j['match'];
					$f++;
				}	
			}
			if(!empty($score)){
				array_multisort($score, SORT_DESC, $list);
				
				$current_page = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
				$page_items = 20;
				
				$total_items = count($list);
				$total_pages = ceil($total_items / $page_items);
		
				$items_max = $current_page * $page_items;
				$items_min = $items_max - $page_items;
					if ($items_max > $total_items) $items_max = $total_items;
			
				function page_url($page) {
					global $current_page;
					if($page == 'prev') {
						$page = $current_page - 1;
					}
					else if($page == 'next') $page = $current_page + 1;
					
					return "//snelkoppeling.info/user/" . ((isset($_GET['user'])) ? "?user={$_GET['user']}&page={$page}" : "?page={$page}");
				} ?>
					<h3 id="matches">Snelkoppeling Matches <var class="score"><?php echo $total_items ?></var></h3>

					<dl role="list">
				<?php
				//$count = (count($list) > 15) ? 15 : count($list);
				for ($i = $items_min; $i < $items_max; $i++) {
					$match_id = ($list[$i]['A'] == $person_id) ? $list[$i]['B'] : $list[$i]['A'];
					$match_gegevens = "SELECT * FROM gegevens WHERE id = '".clean($match_id)."'";
					if(!$result = $mysqli->query($match_gegevens)) {
						trigger_error('Fout in query: '.$mysqli->error);
					} else {
						$r = $result->fetch_array(MYSQLI_ASSOC);
						if($list[$i]['match'] != 0){
							?>
								<div class="all">
									<dt class="name">
										<?php 
										echo ($i+1).". ";
										
										echo ($r['username'] == "bouke" || $r['username'] == "svenpopping") ? '<img src="../images/crown-gold-icon.png" style="margin-top: -4px;" title="Administrator" alt="Administrator" /> ' : "";
										echo ($r['username'] == "Hiemstra" || $r['username'] == "sietse") ? '<img src="../images/crown-silver-icon.png" style="margin-top: -4px;" title="Overseer" alt="Overseer" /> ' : "";
										
										echo  ucwords($r['name']);
										echo ($user == "bouke" || $user == "svenpopping") ? '<a href="http://snelkoppeling.info/user/?user='.$r['username'].'">&nbsp;<i class="arrow-right"></i></a>' : "";
										?>
									
									</dt>
									<dd class="matches">
										<?php echo ($r['picture'] != "") ? '<a href="//snelkoppeling.info/server/_/large/'.$r['picture'].'" class="view"><img src="//snelkoppeling.info/server/_/thumbnail/'.$r['picture'].'" alt="'.$r['name'].'" class="profile-picture-small" /></a>' : '<img src="//snelkoppeling.info/images/nopicture_thumbnail.jpg" alt="Onbekend" class="profile-picture-small" />'
										?>
										<div class="info">
											<div class="progress-bar__container">
												<span class="progress" style="width:<?php echo $list[$i]['match']; ?>%" data-width="<?php echo $list[$i]['match']; ?>"></span>
											</div> 
											<span><var class="score"><?php echo $list[$i]['match'] ?>% match</var> met <?php echo $r['name']; ?> (<?php echo $r['age']; ?> jaar).</span>
											<div class="clear"></div>
											<div class="info-matches done">
												<dl role="list">
													<dt>Naam</dt>
													<dd>
													<?php echo ($r['username'] == "bouke" || $r['username'] == "svenpopping") ? '<img src="../images/crown-gold-icon.png" style="margin-top: -4px;" title="Administrator" alt="Administrator" /> ' : "";
													echo ($r['username'] == "Hiemstra" || $r['username'] == "sietse") ? '<img src="../images/crown-silver-icon.png" style="margin-top: -4px;" title="Overseer" alt="Overseer" /> ' : "";
													echo ucwords($r['name']) ?></dd>
													<dt>Geslacht</dt>
													<dd><?php echo($r['gender'] == 0)? "Man" : (($r['gender'] == 1) ? "Vrouw" : "Onbekend") ?></dd>
													<dt>Geaardheid</dt>
													<dd><?php echo($r['sexse'] == 0)? "Heteroseksueel" : (($r['sexse'] == 1) ? "Homosexueel" : "Bisexueel") ?></dd>
													<dt>Provincie</dt>
													<dd>
													<?php 
													$states = array(
														0 => "Friesland", 
														1 => "Groningen", 
														2 => "Drenthe",
														3 => "Noord-Holland",
														4 => "Flevoland",
														5 => "Overijssel", 
														6 => "Gelderland", 
														7 => "Utrecht", 
														8 => "Zuit-Holland",
														9 => "Zeeland", 
														10 => "Noord-Brabant",
														11 => "Limburg"
													);
													echo $states[$r['state']];
													 ?>
													</dd>
													<dt>Leeftijd</dt>
													<dd><?php echo $r['age'] ?> jaar</dd>
													<dt>Stuur deze persoon een bericht...</dt>
													<dd>
														De berichten functie is tijdelijk uitgeschakeld!
														<!--<form action="#contact" method="post">
																	<input type="hidden" name="to_name" value="<?php echo $r['name'] ?>" />
																	<input type="hidden" name="to_mail" value="<?php echo $r['email'] ?>" />
														
																		<textarea name="message" class="large float-left"> </textarea>&nbsp;<input type="submit" value="Verstuur" />
																</form>-->
													</dd>
												</dl>
											</div>
										</div>
									</dd>
								</div>
									<div class="clear"></div>
									
							<?php
							}
						}
					}
					?>
					
					</dl>
					
					<nav class="page">
						<ul role="navigation">	
							<?php 
								if($current_page > 1) {
									echo '<li class="page-first"><a href="' . page_url(1) . '" rel="first bookmark">Eerste</a></li>';
									echo '<li class="page-prev"><a href="' . page_url('prev') . '" rel="prev"><i class="prev"></i> Vorige</a></li>'; 
								}
								
								for($i = 1; $i <= $total_pages; $i++) {
									if($i <> $current_page) {
										echo '<li><a href="' . page_url($i) . '">' . $i . '</a></li>';
									} 
									else echo '<li class="page-current"><strong>' . $i . '</strong></li>';
								}
								
								if($current_page < $total_pages) {
									echo '<li class="page-next"><a href="' . page_url('next') . '" rel="next">Volgende <i class="next"></i></a></li>'; 
								}
							?>
							
						</ul>
					</nav>
					
					<?php
				} else {
					?>
						<h3 id="matches">Snelkoppeling Matches</var></h3>
						<p style='font-size: .8em;
						color: #999;'>Nog geen matches kunnen vinden (in jouw leeftijdscategorie), kom later terug wanneer nieuwe personen zich aangemeld hebben!</p>
					<?php
				}
		}
	?>