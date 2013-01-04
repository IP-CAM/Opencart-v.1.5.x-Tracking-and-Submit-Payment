<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php echo $text_description; ?>

  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="return">
    <h2><?php echo $text_user; ?></h2>
    <div class="content">
      <div class="left"><span class="required">*</span> <?php echo $entry_order_id; ?><br />
        <input type="text" name="order_id" value="<?php echo $order_id; ?>" class="large-field" />
        <br />
        <?php if ($error_order_id) { ?>
        <span class="error"><?php echo $error_order_id; ?></span>
        <?php } ?>
        <?php if ($error_order_verify) { ?>
        <span class="error"><?php echo $error_order_verify; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_name; ?><br />
        <input type="text" name="name" value="<?php echo $name; ?>" class="large-field" />
        <br />
        <?php if ($error_name) { ?>
        <span class="error"><?php echo $error_name; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_email; ?><br />
        <input type="text" name="email" value="<?php echo $email; ?>" class="large-field" />
        <br />
        <?php if ($error_email) { ?>
        <span class="error"><?php echo $error_email; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_telephone; ?><br />
        <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="large-field" />
        <br />
        <?php if ($error_telephone) { ?>
        <span class="error"><?php echo $error_telephone; ?></span>
        <?php } ?>
        <br />
      </div>
      <div class="right">
        <?php echo $entry_date_ordered; ?><br />
        <input type="text" name="date_ordered" value="<?php echo $date_ordered; ?>" class="large-field date" />
        <br />
      </div>
    </div>
    
    <h2><?php echo $text_payment_method; ?></h2>
    <div class="content">
    <span class="required">*</span> <b><?php echo $text_transfer_method; ?></b><br />
          <table>
            <tr>
              <td width="1"><input type="radio" name="payment" value="<?php echo $text_deposit; ?>" id="payment_deposit" <?php echo ($payment==$text_deposit)? 'checked="checked"' : ''; ?> /></td>
              <td><label for="payment_deposit"><?php echo $text_deposit; ?></label></td>
            </tr>
            <tr>
              <td width="1"><input type="radio" name="payment" value="<?php echo $text_counter_service; ?>" id="payment_counter" <?php echo ($payment==$text_counter_service)? 'checked="checked"' : ''; ?>/></td>
              <td><label for="payment_counter"><?php echo $text_counter_service; ?></label></td>
            </tr>
            <tr>
              <td width="1"><input type="radio" name="payment" value="<?php echo $text_internet; ?>" id="payment_internet" <?php echo ($payment==$text_internet)? 'checked="checked"' : ''; ?> /></td>
              <td><label for="payment_internet"><?php echo $text_internet; ?></label></td>
            </tr>
            <tr>
              <td width="1"><input type="radio" name="payment" value="<?php echo $text_atm; ?>" id="payment_atm" <?php echo ($payment==$text_atm)? 'checked="checked"' : ''; ?> /></td>
              <td><label for="payment_atm"><?php echo $text_atm; ?></label></td>
            </tr>
          </table>
        <br />
    </div>
    
    <h2><?php echo $text_payment; ?></h2>
    <div class="content">
      <div class="left">
        <span class="required">*</span> <?php echo $entry_bank; ?><br />
        <input type="text" name="bank" value="<?php echo $bank; ?>" class="large-field" />
        <br />
        <?php if ($error_bank) { ?>
        <span class="error"><?php echo $error_bank; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_total; ?><br />
        <input type="text" name="total" value="<?php echo $total; ?>" class="large-field" />
        <br />
        <?php if ($error_total) { ?>
        <span class="error"><?php echo $error_total; ?></span>
        <?php } ?>
        <br />        
      </div>
      <div class="right">
        <span class="required">*</span> <?php echo $entry_payment_date; ?><br />
        <input type="text" name="payment_date" value="<?php echo $payment_date; ?>" class="large-field date" />
        <br />
        <?php if ($error_payment) { ?>
        <span class="error"><?php echo $error_payment; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_slip_no; ?><br />
        <input type="text" name="slip_no" value="<?php echo $slip_no; ?>" class="large-field" />
        <br />
        <?php if ($error_slip) { ?>
        <span class="error"><?php echo $error_slip; ?></span>
        <?php } ?>
        <br />
      </div>
    </div>
    
    <h2><?php echo $text_additional; ?></h2>
    
    <table class="list">
    <tbody>
      <tr>
        <td class="left"><textarea name="comment" cols="50" rows="6"><?php echo $comment; ?></textarea></td>
      </tr>
      <tr>
        <td class="left" style="width: 50%;"><input type="text" name="captcha" value="<?php echo $captcha; ?>" />
        <br />
        <img src="index.php?route=tracking/board/captcha" alt="" />
        <?php if ($error_captcha) { ?>
        <span class="error"><?php echo $error_captcha; ?></span>
        <?php } ?>
        </td>
      </tr>
    </tbody>
  </table>

    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><span><?php echo $button_back; ?></span></a></div>
      <div class="right"><a onclick="$('#return').submit();" class="button"><span><?php echo $button_submit; ?></span></a></div>
    </div>
  </form>

  
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
