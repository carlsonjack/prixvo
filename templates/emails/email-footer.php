<?php
/**
 * Email Footer
 *
 */

defined( 'ABSPATH' ) || exit;

$uat_mail_f_taxt = get_option('uat_mail_f_taxt');
$site_url = site_url();

$uat_theme = '<a href="https://getultimateauction.com/" style="color: '.$uat_mail_base_color.'; font-weight: normal; text-decoration: underline;">Ultimate Auction Pro Software</a>';

$footer_text = str_replace('{Ultimate Auction Pro Software}', $uat_theme, $uat_mail_f_taxt);
$footer_text = str_replace('{site_url}', $site_url, $footer_text);
$footer_text = str_replace('{site_title}', $blogname, $footer_text);

?>
															</div>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>

								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">

						<table border="0" cellpadding="10" cellspacing="0" width="600" id="uat_template_footer">
							<tr>
								<td valign="top">
									<table border="0" cellpadding="10" cellspacing="0" width="100%">
										<tr>
											<td colspan="2" valign="middle" id="credit">
												<?php echo $footer_text; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
