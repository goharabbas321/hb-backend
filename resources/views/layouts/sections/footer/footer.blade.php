@php
$containerFooter = (isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="text-body">
        © <script>document.write(new Date().getFullYear())</script>, {{ __('messages.footer.copyright') }} <a href="{{ $systemSettings['company_url'] }}" target="_blank" class="footer-link">{{ (app()->getLocale() == "ar") ? $systemSettings['company_name_ar'] : $systemSettings['company_name'] }}</a> {{ __('messages.footer.copyright_end') }} <a href="{{ $systemSettings['creator_url'] }}" target="_blank" class="footer-link">{{ (app()->getLocale() == "ar") ? $systemSettings['creator_name_ar'] : $systemSettings['creator_name'] }}</a>
      </div>
    </div>
  </div>
</footer>
<!--/ Footer-->
