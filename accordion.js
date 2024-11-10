// const ACCORDION_MODULE = (main) => {

//     const closeAllAccordions = () => {
//         const buttons = document.querySelectorAll("button");
//         buttons.forEach((button) => button.setAttribute("aria-expanded", "false"));
//     };

//     const setButtonTabIndex = (nextNumber) => {
//         document.querySelectorAll("section button").forEach((section) => {
//             section.tabIndex = -1;
//             if (parseInt(section.dataset.index) === nextNumber) {
//                 section.tabIndex = 0;
//             }
//         });
//     };

//     const toggleAccordion = (event) => {
//         const button = event.target;

//         if (button.getAttribute("aria-expanded") === "true") {
//             button.setAttribute("aria-expanded", "false");
//         } else {
//             closeAllAccordions();
//             button.setAttribute("aria-expanded", "true");
//         }
//     };

//     const handleMainPress = (e) => {
//         if (e.code === "Tab") {
//             const nextNumber = parseInt(e.target.dataset.index) + 1;
//             setButtonTabIndex(nextNumber < main.childElementCount ? nextNumber : 0);

//         }

//         if ((e.code === "Enter" || e.code === "Space") && e.target.localName === "button") {
//             e.preventDefault();
//             toggleAccordion(e);
//         }
//     };

//     const handleMainClick = (e) => {
//         if (e.target.localName === "button") {
//             e.stopImmediatePropagation();
//             toggleAccordion(e);
//         }
//     };

//     return { handleMainClick, handleMainPress };
// };

// addEventListener("DOMContentLoaded", () => {
//     var links = document.querySelectorAll( '.main a' );

//     for( var i = 0, j =  links.length; i < j; i++ ) {
//         links[i].setAttribute( 'tabindex', '-1' );
//     }

//     const main = document.querySelector(".main");

//     main.addEventListener("click", ACCORDION_MODULE(main).handleMainClick);
//     main.addEventListener("keydown", ACCORDION_MODULE(main).handleMainPress);
// });

// const ACCORDION_MODULE = (main) => {
//     const closeAllAccordions = () => {
//         const buttons = document.querySelectorAll("button");
//         buttons.forEach((button) => button.setAttribute("aria-expanded", "false"));
//         const panels = document.querySelectorAll(".content");
//         panels.forEach((panel) => panel.classList.remove("active"));
//     };

//     const setElementTabIndex = (element, nextNumber) => {
//         document.querySelectorAll(`.${element} ${element}`).forEach((item) => {
//             item.tabIndex = -1;
//             if (parseInt(item.dataset.index) === nextNumber) {
//                 item.tabIndex = 0;
//             }
//         });
//     };

//     const toggleAccordion = (event) => {
//         const button = event.target;
//         const panel = button.nextElementSibling;
//         if (button.getAttribute("aria-expanded") === "true") {
//             button.setAttribute("aria-expanded", "false");
//             panel.classList.remove("active");
//             const links = panel.querySelectorAll("a");
//             links.forEach((link) => link.setAttribute("tabindex", "-1"));
//         } else {
//             closeAllAccordions();
//             button.setAttribute("aria-expanded", "true");
//             panel.classList.add("active");
//             const links = panel.querySelectorAll("a");
//             links.forEach((link) => link.setAttribute("tabindex", "0"));
//         }
//     };

//     const handleMainPress = (e) => {
//         if (e.code === "Tab") {
//             const nextNumber = parseInt(e.target.dataset.index) + 1;
//             setElementTabIndex("button", nextNumber < main.childElementCount ? nextNumber : 0);
//             setElementTabIndex("a", nextNumber < main.childElementCount ? nextNumber : 0);
//         }

//         if ((e.code === "Enter" || e.code === "Space") && e.target.localName === "button") {
//             e.preventDefault();
//             toggleAccordion(e);
//         }
//     };

//     const handleMainClick = (e) => {
//         if (e.target.localName === "button") {
//             e.stopImmediatePropagation();
//             toggleAccordion(e);
//         }
//     };

//     return { handleMainClick, handleMainPress };
// };

// addEventListener("DOMContentLoaded", () => {
//     const main = document.querySelector(".main");

//     main.addEventListener("click", ACCORDION_MODULE(main).handleMainClick);
//     main.addEventListener("keydown", ACCORDION_MODULE(main).handleMainPress);
// });

const ACCORDION_MODULE = (main) => {
  const closeAllAccordions = () => {
    const buttons = document.querySelectorAll("button");
    buttons.forEach((button) => button.setAttribute("aria-expanded", "false"));
    const panels = document.querySelectorAll(".content");
    panels.forEach((panel) => panel.classList.remove("active"));
  };

  const setElementTabIndex = (element, nextNumber) => {
    document.querySelectorAll(`.${element} ${element}`).forEach((item) => {
      item.tabIndex = -1;
      if (parseInt(item.dataset.index) === nextNumber) {
        item.tabIndex = 0;
      }
    });
  };

  const toggleAccordion = (event) => {
    const button = event.target;
    const panel = button.nextElementSibling;
    if (button.getAttribute("aria-expanded") === "true") {
      button.setAttribute("aria-expanded", "false");
      panel.classList.remove("active");
      const links = panel.querySelectorAll("a");
      links.forEach((link) => link.setAttribute("tabindex", "-1"));
    } else {
      closeAllAccordions();
      button.setAttribute("aria-expanded", "true");
      panel.classList.add("active");
      const links = panel.querySelectorAll("a");
      links.forEach((link) => link.setAttribute("tabindex", "0"));
    }

    // Move focus to the next accordion button if the current panel is being closed
    if (button.getAttribute("aria-expanded") === "false") {
      const nextButton =
        button.parentElement.nextElementSibling.querySelector("button");
      if (nextButton) {
        nextButton.focus();
      }
    }
  };
  const handleMainPress = (e) => {
    if (e.code === "Tab" && e.target.tagName === "A") {
      const accordionContent = e.target.closest(".content");
      if (
        accordionContent &&
        accordionContent.parentElement
          .querySelector("button")
          .getAttribute("aria-expanded") === "false"
      ) {
        e.preventDefault();
      }
    }

    if (
      (e.code === "Enter" || e.code === "Space") &&
      e.target.localName === "button"
    ) {
      e.preventDefault();
      toggleAccordion(e);
    }

    if (e.code === "Tab") {
      const nextNumber = parseInt(e.target.dataset.index) + 1;
      setButtonTabIndex(nextNumber < main.childElementCount ? nextNumber : 0);
    }
  };
  const handleMainClick = (e) => {
    if (e.target.localName === "button") {
      e.stopImmediatePropagation();
      toggleAccordion(e);
    }
  };

  return { handleMainClick, handleMainPress };
};

addEventListener("DOMContentLoaded", () => {
  const main = document.querySelector(".main");

  main.addEventListener("click", ACCORDION_MODULE(main).handleMainClick);
  main.addEventListener("keydown", ACCORDION_MODULE(main).handleMainPress);
});
