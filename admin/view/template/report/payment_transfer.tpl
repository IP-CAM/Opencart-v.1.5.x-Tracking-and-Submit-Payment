<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="filter">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $entry_payment_method; ?>
            <select name="filter_payment_transfer">
              <option value="0" selected="selected"><?php echo $text_all_payment; ?></option>
              <option value="<?php echo $text_deposit; ?>" <?php echo ($filter_payment_transfer==$text_deposit)? 'selected="selected"' : ''; ?>><?php echo $text_deposit; ?></option>
              <option value="<?php echo $text_counter_service; ?>" <?php echo ($filter_payment_transfer==$text_counter_service)? 'selected="selected"' : ''; ?>><?php echo $text_counter_service; ?></option>
              <option value="<?php echo $text_internet; ?>" <?php echo ($filter_payment_transfer==$text_internet)? 'selected="selected"' : ''; ?>><?php echo $text_internet; ?></option>
              <option value="<?php echo $text_atm; ?>" <?php echo ($filter_payment_transfer==$text_atm)? 'selected="selected"' : ''; ?>><?php echo $text_atm; ?></option>
            </select></td>
          <td><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_customer; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_payment_method; ?></td>
            <td class="right"><?php echo $column_payment_date; ?></td>
            <td class="left"><?php echo $column_slip_no; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($payments) { ?>
          <?php foreach ($payments as $payment) { ?>
          <tr>
            <td class="left"><?php echo $payment['customer']; ?></td>
            <td class="left"><?php echo $payment['email']; ?></td>
            <td class="left"><?php echo $payment['payment_method']; ?></td>
            <td class="right"><?php echo $payment['payment_date']; ?></td>
            <td class="right"><?php echo $payment['slip_no']; ?></td>
            <td class="right"><?php echo $payment['total']; ?></td>
            <td class="right"><?php foreach ($payment['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/payment_transfer&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_payment_transfer = $('select[name=\'filter_payment_transfer\']').attr('value');
	
	if (filter_payment_transfer) {
		url += '&filter_payment_transfer=' + encodeURIComponent(filter_payment_transfer);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>