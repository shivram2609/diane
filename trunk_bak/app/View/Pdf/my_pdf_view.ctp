<?php
	App::import('Vendor','xtcpdf');
	$pdf = new XTCPDF('L', 'mm', 'A4', true, 'UTF-8', true);
    $html = '<div style="background:#FFFFFF; border:10px solid #0B232B;  margin:3px auto 0; padding:5px 5px 5px 5px;">
		<div style="border:10px solid #2BB14B;">
		<table cellpadding="0" cellspacing="0" style="width:100%;" >
			<tr>
				<td  style="text-align:center; width:25%;">
					<img src="'.SITE_LINK.'/app/webroot/img/certification-logo.png"  style=" position:absolute; top:-20px;" />
				</td>
				<td align="center" style="font-family:folks-lightregular; padding:100px 0 0; text-align:center; width:75%;" ><br/><br/>
					<img src="'.SITE_LINK.'/app/webroot/img/certificate-text.png" alt="" /><br/><br/><br/>
					<h1 style="color:#0B232B; font-size:200%; font-weight:normal; line-height:0;">'.$username.'</h1>
					
					<p  style="color:#0A0A0A; float:left; font-size:150%; padding:0;">has successfully completed <br>
					'.$coursename.'</p><br/>
					<table align="center" width="100%">
						<tr>
							<td style="text-align:center;" width="40%"><br /><br />
								<p style="color:#0A0A0A;   font-size:100%; text-align:center; width:75%;">'.$instructor.', Instructor</p>
							</td>
							<td width="10%">&nbsp;</td>
							<td style="text-align:center;"><br /><br />
								<p style="color:#0A0A0A; font-size:100%; text-align:center; width:75%;">'.date("F d, Y",strtotime($date)).'</p>
							</td>
							<td><br /><br /><br />
								<img src="'.SITE_LINK.'/app/webroot/img/certificate-degree.png" alt="" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>
	</div>';
	$pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->lastPage();
	$pdf->Output(WWW_ROOT."/files/pdf/completion_certificate_for_".trim($coursename).$userid.".pdf", 'F');
	$this->Common->download("completion_certificate_for_".trim($coursename).$userid.".pdf");
?>
<script type="text/javascript">
	//location.href = "<?php echo SITE_LINK."courses/download/completion_certificate_for_".trim($coursename).$userid.".pdf"; ?>"
</script>

