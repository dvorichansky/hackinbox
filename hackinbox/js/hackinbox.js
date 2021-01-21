/**
 * hackinbox JS *
 * @author dvorichansky
 */

(function() {
  /**
   * function
   * (native js)
   */
  class HackinboxEvent {
    hackinbox = document.querySelector(".hackinbox");
    hackinboxOverlay = document.querySelector(".hackinbox-overlay");
    hackinboxClose = document.querySelectorAll("[data-hackinbox=close]");
    modalElementAll = document.querySelectorAll(".modal");

    hackinboxHide() {
      this.hackinboxOverlay.style.cssText = "display:none !important";
      this.hackinbox.style.cssText = "display:none !important";
      this.modalElementAllHide(false);
      activateSetCookie();
    }

    hackinboxShow() {
      this.hackinboxOverlay.style.cssText = "display:block !important";
      this.hackinbox.style.cssText = "display:block !important";
      this.modalElementAllHide(true);
    }

    hackinboxEventClose() {
      this.hackinboxClose.forEach(event =>
        event.addEventListener("click", () => this.hackinboxHide())
      );
    }

    modalElementAllHide(status) {
      if (!this.hackinbox.classList.contains("hackinbox-hide")) {
        this.modalElementAll.forEach(el => {
          status === true
            ? el.classList.add("hackinbox-hide")
            : el.classList.remove("hackinbox-hide");
        });
      }
    }
  }

  /**
   * URL configuration
   * (native js)
   */
  const url_widget = `${location.origin}/hackinbox/`;
  const url_json = `${url_widget}hackinbox_data.json`;
  let hackinboxShowStatus = false;

  /**
   * request for data
   * (native js)
   */
  fetch(url_json)
    .then(response => connectTrack(response))
    .then(data => {
      parsingData(data);
    })
    .catch(err => {
      throw err;
    });

  function connectTrack(response) {
    if (response.status === 200) {
      console.log("Successful connection!");
      return response.json();
    } else if (response.status === 300) {
      console.log("Queue...");
    }
  }

  function parsingData(data) {
    if (checkForComplianceWithTheExceptionPage(data.exception_pages)) return;

    if (data.status == "OFF" || checkDisplayTime(data.display_time))
      return activateSetCookie();

    hackinboxRender(data);
    hackinboxForm(data.form.configuration_file);
    setTimeInitializeClock(data.counter.deadline);

    if(data.display_out_page_focus == 'on') {
      onmouseoutListener();
    }

    setTimeout(() => {
      hackinboxCallShow();
    }, +data.display_delay * 1000);
  }

  function hackinboxCallShow() {
    if(!hackinboxShowStatus) {
      const hackinboxEvent = new HackinboxEvent();
      hackinboxEvent.hackinboxShow();
      hackinboxEvent.hackinboxEventClose();
      hackinboxShowStatus = true;
    }
  }

  /**
   * Track loss of focus with page
   */
  function onmouseoutListener() {
    document.body.onmouseout = function(event) {
      if(event.relatedTarget === null) {
        hackinboxCallShow();
      }
    }
  }

  function langDefinition() {
    const lang = document.getElementsByTagName("html")[0].lang;
    return lang === "uk" ? "uk" : "ru"; // "ru" default language
  }

  /**
   * Check Display Time
   * compares day, hours, minutes
   * (native js)
   */
  function checkDisplayTime(time) {
    const date = new Date(),
      day = +date.getDay(),
      hours = +date.getHours(),
      minutes = +date.getMinutes(),
      clock_with = time.clock.with.split(":"),
      clock_on = time.clock.on.split(":");

    if (time.day_week[day] === "off") {
      return true;
    } else {
      if (hours >= +clock_with[0] && hours <= +clock_on[0]) {
        if (hours == +clock_with[0]) {
          return minutes <= +clock_with[1];
        }
        if (hours == +clock_on[0]) {
          return minutes >= +clock_on[1];
        }
      }
    }
  }

  /**
   * render html
   * (native js)
   */
  function hackinboxRender(data) {
    const lang = langDefinition();
    const { appearance, content, counter, form } = data;
    const { deadline } = counter;

    document.body.insertAdjacentHTML(
      "beforeend",
      `<div class="hackinbox">
            <div class="hackinbox-container">
                <div class="hackinbox-picture">
                    <picture>
                        <source type="image/webp" srcset="${url_widget}img/webp/hackinbox_picture__${lang}.webp">
                        <img class="hackinbox-picture__img" src="${url_widget}img/png/hackinbox_picture__${lang}.png" />
                    </picture>
                </div>
                <div class="hackinbox-content">                                  
                    <a href="javascript:void(0)" class="hackinbox-close" data-hackinbox="close">×</a>
                    <div class="hackinbox-content__title">${
                      content.title[lang]
                    }</div>

                    <div class="hackinbox-counter">
                        <div class="hackinbox-counter__title">${
                          counter.title[lang]
                        }</div>
                        <div class="hackinbox-counter-clock">
                            <div class="hackinbox-counter-clock__dig">
                                <div class="hackinbox-counter-clock__number hackinbox-counter-clock__number-hours">00</div>
                                <div class="hackinbox-counter-clock__name">${
                                  deadline.hours_text[lang]
                                }</div>
                            </div>
                            <div class="hackinbox-counter-clock__dz"></div>
                            <div class="hackinbox-counter-clock__dig">
                                <div class="hackinbox-counter-clock__number hackinbox-counter-clock__number-minutes">23</div>
                                <div class="hackinbox-counter-clock__name">${
                                  deadline.minutes_text[lang]
                                }</div>
                            </div>
                            <div class="hackinbox-counter-clock__dz"></div>
                            <div class="hackinbox-counter-clock__dig">
                                <div class="hackinbox-counter-clock__number hackinbox-counter-clock__number-seconds">58</div>
                                <div class="hackinbox-counter-clock__name">${
                                  deadline.seconds_text[lang]
                                }</div>
                            </div>
                        </div>
                    </div>
                
                    <form class="hackinbox-form" action="POST">
                        <input type="hidden" name="form" value="${
                          form.name[lang]
                        }">
                        <input type="hidden" name="referer" value="${location.hostname +
                          location.pathname}">
                        <input 
                          type="tel" 
                          name="phone" 
                          class="hackinbox-form__input hackinbox-form__userphone" 
                          value="${form.mask}"
                          placeholder="${form.placeholder}" 
                          maxlength="34">
                        <small class="hackinbox-form__message-error">${
                          form.userphone_message_error[lang]
                        }</small>
                        <button 
                          type="submit" 
                          class="hackinbox-form__button"
                        >${form.button[lang]}</button>  
                        <div class="hackinbox-form__success">
                            <div class="hackinbox-form__success-text">${
                              form.success_text[lang]
                            }</div>
                            <button 
                              type="button" 
                              class="hackinbox-form__button hackinbox-form__success-button" 
                              data-hackinbox="close">${
                                form.success_button[lang]
                              }</button>
                        </div>                      
                    </form>                    
                </div>
            </div>
        </div>
        <div class="hackinbox-overlay" data-hackinbox="close"></div>
        <style id="hackinbox_style">
          ${
            appearance.box_shadow
              ? `.hackinbox{box-shadow:${appearance.box_shadow}}`
              : ""
          }
          ${
            content.background_color
              ? `.hackinbox-content{background-color:#${content.background_color}}`
              : ""
          }
          ${
            content.title_color
              ? `.hackinbox-content__title{color:#${content.title_color}}`
              : ""
          }
          ${
            appearance.overlay
              ? `.hackinbox-overlay{background-color:#${appearance.overlay.background_color};opacity:${appearance.overlay.opacity}}`
              : ""
          }
          ${
            form.button_color
              ? `.hackinbox-form__button{background-color:#${form.button_color};}`
              : ""
          }
          ${
            form.success_button_color
              ? `.hackinbox-form__success-button{background-color:#${form.success_button_color};}`
              : ""
          }
          ${
            counter.color || counter.background_color
              ? `.hackinbox-counter-clock__number,.hackinbox-counter-clock__dz:before,.hackinbox-counter-clock__dz:after{background-color:#${counter.background_color};color:#${counter.color};}`
              : ""
          }
        </style>`
    );
    let event = new CustomEvent("hackinboxRender");
    document.dispatchEvent(event);
  }

  /**
   * hackinbox Set Cookie
   * (native js)
   */
  function setCookie(name, value, options = {}) {
    options = {
      path: "/",
      // add other default values if necessary
      ...options
    };

    if (options.expires) {
      options.expires = options.expires.toUTCString();
    }

    let updatedCookie =
      encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
      updatedCookie += "; " + optionKey;
      let optionValue = options[optionKey];
      if (optionValue !== true) {
        updatedCookie += "=" + optionValue;
      }
    }

    document.cookie = updatedCookie;
  }

  function activateSetCookie() {
    setCookie("hackinbox", "loaded", { "max-age": 86400 });
  }

  /**
   * form
   * (used jQuery)
   */
  function hackinboxForm(configuration_file) {
    const $form = $(".hackinbox-form");
    const $phone = $form.find("[name=phone]");
    const $submit = $form.find("[type=submit]");

    inputMaskInitialize($phone[0]);

    document.addEventListener("submit", function(e) {
      const target = e.target;
      if (!target.classList.contains("hackinbox-form")) {
        return;
      }
      e.preventDefault();

      if ($phone[0].value.indexOf("_") !== -1) {
        $phone.addClass("hackinbox-form__userphone-error");
        return;
      }
      $phone.removeClass("hackinbox-form__userphone-error");

      $submit.prop("disabled", true);

      $.ajax({
        type: "POST",
        url: configuration_file,
        data: $(target).serialize(),
        dataType: "html",
        beforeSend: function() {},
        success: function(data) {
          let event = new CustomEvent("hackinboxFormSuccess");
          target.dispatchEvent(event);

          $(target)
            .contents()
            .filter(function() {
              return this.classList != "hackinbox-form__success";
            })
            .remove();
          $(".hackinbox-counter, .hackinbox-content__title").remove();
          activateSetCookie();
        },
        error: function() {
          let event = new CustomEvent("hackinboxFormError");
          target.dispatchEvent(event)
        }
      });
    });
  }

  /**
   * mask input
   * (native js)
   */
  function inputMaskInitialize(inputPhone) {
    function setCursorPosition(pos, elem) {
      elem.focus();
      if (elem.setSelectionRange) elem.setSelectionRange(pos, pos);
      else if (elem.createTextRange) {
        const range = elem.createTextRange();
        range.collapse(true);
        range.moveEnd("character", pos);
        range.moveStart("character", pos);
        range.select();
      }
    }

    function mask() {
      let matrix = this.defaultValue,
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, "");
      def.length >= val.length && (val = def);
      matrix = matrix.replace(/[_\d]/g, function(a) {
        return val.charAt(i++) || "_";
      });
      this.value = matrix;
      i = matrix.lastIndexOf(val.substr(-1));
      i < matrix.length && matrix != this.defaultValue
        ? i++
        : (i = matrix.indexOf("_"));
      setCursorPosition(i, this);
    }

    inputPhone.addEventListener("input", mask, false);
  }

  /**
   * countdown counter
   * (native js)
   */
  function setTimeInitializeClock(time) {
    const time_formula =
      +time.hours * 60 * 60 + +time.minutes * 60 + +time.seconds;
    const deadline = new Date(Date.parse(new Date()) + time_formula * 1000);
    // initialize clock
    initializeClock(".hackinbox-counter-clock", deadline);
  }

  function getTimeRemaining(endtime) {
    const t = Date.parse(endtime) - Date.parse(new Date());
    const seconds = Math.floor((t / 1000) % 60);
    const minutes = Math.floor((t / 1000 / 60) % 60);
    const hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    return {
      total: t,
      hours: hours,
      minutes: minutes,
      seconds: seconds
    };
  }

  function initializeClock(block, endtime) {
    const clock = document.querySelector(block);
    const classBem = ".hackinbox-counter-clock__number";
    const hours = clock.querySelector(`${classBem}-hours`);
    const minutes = clock.querySelector(`${classBem}-minutes`);
    const seconds = clock.querySelector(`${classBem}-seconds`);

    function updateClock() {
      const t = getTimeRemaining(endtime);

      hours.innerHTML = ("0" + t.hours).slice(-2);
      minutes.innerHTML = ("0" + t.minutes).slice(-2);
      seconds.innerHTML = ("0" + t.seconds).slice(-2);

      if (t.total <= 0) {
        clearInterval(timeinterval);
      }
    }

    updateClock();
    const timeinterval = setInterval(updateClock, 1000);
  }

  function checkForComplianceWithTheExceptionPage(pages) {
    if (pages) {
      const result = pages.some(
        el => el == location.hostname + location.pathname
      );
      console.log(
        result
          ? "Page excluded for hackinbox"
          : "The page is allowed to display hackinbox"
      );
      return result;
    }
  }
})();
