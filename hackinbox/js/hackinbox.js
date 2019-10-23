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
    constructor() {
      this.hackinbox = document.querySelector(".hackinbox");
      this.hackinboxOverlay = document.querySelector(".hackinbox-overlay");
      this.hackinboxClose = document.querySelectorAll("[data-hackinbox=close]");
    }

    hackinboxHide() {
      this.hackinboxOverlay.style.cssText = "display:none !important";
      this.hackinbox.style.cssText = "display:none !important";
      activateSetCookie();
    }

    hackinboxShow() {
      this.hackinboxOverlay.style.cssText = "display:block !important";
      this.hackinbox.style.cssText = "display:block !important";
    }

    hackinboxEventClose() {
      this.hackinboxClose.forEach(event =>
        event.addEventListener("click", this.hackinboxHide.bind(this))
      );
    }
  }

  /**
   * URL configuration
   * (native js)
   */
  const url_widget = `${location.origin}/hackinbox/`;
  const url_json = `${url_widget}hackinbox_data.json`;

  /**
   * request for data
   * (native js)
   */
  fetch(url_json)
    .then(response => {
      if (response.status === 200) {
        console.log("Successful connection!");
        return response.json();
      } else if (response.status === 300) {
        console.log("Queue...");
      }
    })
    .then(data => {
      if (checkForComplianceWithTheExceptionPage(data.exception_pages)) return;

      if (data.status == "OFF") return activateSetCookie();

      hackinboxRender(data);
      hackinboxForm(data.hackinbox_form.configuration_file);
      setTimeInitializeClock(data.hackinbox_counter.deadline);

      setTimeout(() => {
        const hackinboxEvent = new HackinboxEvent();
        hackinboxEvent.hackinboxShow();
        hackinboxEvent.hackinboxEventClose();
      }, +data.display_delay * 1000);
    })
    .catch(err => {
      throw err;
    });

  /**
   * render html
   * (native js)
   */
  function hackinboxRender(data) {
    const content = data.hackinbox_content;
    const form = data.hackinbox_form;
    const counter = data.hackinbox_counter;
    const appearance = data.hackinbox_appearance;

    document.body.insertAdjacentHTML(
      "beforeend",
      `<div class="hackinbox">
            <div class="hackinbox-container">
                <div class="hackinbox-picture">
                    <img class="hackinbox-picture__img" src="${url_widget}img/hackinbox_picture.png" />
                </div>
                <div class="hackinbox-content">                                  
                    <a href="javascript:void(0)" class="hackinbox-close" data-hackinbox="close">×</a>
                    <div class="hackinbox-content__title">${content.title}</div>

                    <div class="hackinbox-counter">
                        <div class="hackinbox-counter__title">${
                          counter.title
                        }</div>
                        <div class="hackinbox-counter-clock">
                            <div class="hackinbox-counter-clock__dig">
                                <div class="hackinbox-counter-clock__number hackinbox-counter-clock__number-hours">00</div>
                                <div class="hackinbox-counter-clock__name">часы</div>
                            </div>
                            <div class="hackinbox-counter-clock__dz"></div>
                            <div class="hackinbox-counter-clock__dig">
                                <div class="hackinbox-counter-clock__number hackinbox-counter-clock__number-minutes">23</div>
                                <div class="hackinbox-counter-clock__name">минуты</div>
                            </div>
                            <div class="hackinbox-counter-clock__dz"></div>
                            <div class="hackinbox-counter-clock__dig">
                                <div class="hackinbox-counter-clock__number hackinbox-counter-clock__number-seconds">58</div>
                                <div class="hackinbox-counter-clock__name">секунды</div>
                            </div>
                        </div>
                    </div>
                
                    <form class="hackinbox-form" action="POST">
                        <input type="hidden" name="form" value="${form.name}">
                        <input type="hidden" name="referer" value="${
                          location.href
                        }">
                        <input 
                          type="tel" 
                          name="phone" 
                          class="hackinbox-form__input hackinbox-form__userphone" 
                          value="${form.mask}"
                          placeholder="${form.placeholder}" 
                          maxlength="34">
                        <small class="hackinbox-form__message-error">${
                          form.userphone_message_error
                        }</small>
                        <button 
                          type="submit" 
                          class="hackinbox-form__button"
                        >${form.button}</button>  
                        <div class="hackinbox-form__success">
                            <div class="hackinbox-form__success-text">${
                              form.success_text
                            }</div>
                            <button 
                              type="button" 
                              class="hackinbox-form__button hackinbox-form__success-button" 
                              data-hackinbox="close">${
                                form.success_button
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
    const phone = $(".hackinbox-form [name=phone]");
    const submit = $(".hackinbox-form [type=submit]");
    const inputPhone = document.querySelector(".hackinbox-form [name=phone]");

    inputMaskInitialize(inputPhone);

    document.addEventListener("submit", function(e) {
      const target = e.target;
      if (!target.classList.contains("hackinbox-form")) {
        return;
      }
      e.preventDefault();

      if (inputPhone.value.indexOf("_") !== -1) {
        phone.addClass("hackinbox-form__userphone-error");
        return;
      }
      phone.removeClass("hackinbox-form__userphone-error");

      submit.prop("disabled", true);

      $.ajax({
        type: "POST",
        url: configuration_file,
        data: $(target).serialize(),
        dataType: "html",
        beforeSend: function() {},
        success: function(data) {
          $(target)
            .contents()
            .filter(function() {
              return this.classList != "hackinbox-form__success";
            })
            .remove();
          $(".hackinbox-counter, .hackinbox-content__title").remove();
          activateSetCookie();
        },
        error: function() {}
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
          : "The page is allowed to display hackbox"
      );
      return result;
    }
  }
})();
