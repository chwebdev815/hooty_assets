function registerElements(elements, exampleName) {
  // Listen for errors from each Element, and show error messages in the UI.
  var savedErrors = {};
  elements.forEach(function(element, idx) {
    element.on("change", function(event) {
      if (event.error) {
        error.classList.add("visible");
        savedErrors[idx] = event.error.message;
        errorMessage.innerText = event.error.message;
      } else {
        savedErrors[idx] = null;

        // Loop over the saved errors and find the first one, if any.
        var nextError = Object.keys(savedErrors)
          .sort()
          .reduce(function(maybeFoundError, key) {
            return maybeFoundError || savedErrors[key];
          }, null);

        if (nextError) {
          // Now that they've fixed the current error, show another one.
          errorMessage.innerText = nextError;
        } else {
          // The user fixed the last error; no more errors.
          error.classList.remove("visible");
        }
      }
    });
  });
}

(function($) {
  "use strict";
  $(document).ready(function() {
    // DATATABLE
    // Create a Stripe client.
    var stripe = Stripe("pk_live_W6UmrxH0w2MEFmTpcCpjRI4q00pE7NlXcf");

    // Create an instance of Elements.
    var elements = stripe.elements({
      fonts: [
        {
          cssSrc: "https://fonts.googleapis.com/css?family=Source+Code+Pro"
        }
      ]
    });
    var elementClasses = {
      focus: "focused",
      empty: "empty",
      invalid: "invalid"
    };
    var elementStyles = {
      base: {
        color: "#32325D",
        fontWeight: 500,
        fontFamily: "Source Code Pro, Consolas, Menlo, monospace",
        fontSize: "16px",
        fontSmoothing: "antialiased",

        "::placeholder": {
          color: "#CFD7DF"
        },
        ":-webkit-autofill": {
          color: "#e39f48"
        }
      },
      invalid: {
        color: "#E25950",

        "::placeholder": {
          color: "#FFCCA5"
        }
      }
    };
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)

    var cardNumber = elements.create("cardNumber", {
      style: elementStyles,
      classes: elementClasses
    });
    cardNumber.mount("#example2-card-number");

    var cardExpiry = elements.create("cardExpiry", {
      style: elementStyles,
      classes: elementClasses
    });
    cardExpiry.mount("#example2-card-expiry");

    var cardCvc = elements.create("cardCvc", {
      style: elementStyles,
      classes: elementClasses
    });
    cardCvc.mount("#example2-card-cvc");

    // registerElements([cardNumber, cardExpiry, cardCvc], "example2");
    // Create an instance of the card Element.

    // var card = elements.create("card", { hidePostalCode: true });

    // Add an instance of the card Element into the `card-element` <div>.
    // card.mount("#card-element");

    // Handle real-time validation errors from the card Element.
    // card.addEventListener("change", function(event) {
    //   var displayError = document.getElementById("card-errors");
    //   if (event.error) {
    //     displayError.textContent = event.error.message;
    //   } else {
    //     displayError.textContent = "";
    //   }
    // });

    // Handle form submission.
    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
      console.log(event, "event ");
      let buttonHtml = $(".make-payment").html();
      $(".make-payment")
        .attr("disabled", true)
        .html("Processing...");

      event.preventDefault();

      stripe.createToken(cardNumber).then(function(result) {
        console.log("[ERR]", { result });
        if (result.error) {
          $(".make-payment")
            .attr("disabled", false)
            .html(buttonHtml);
          // Inform the user if there was an error.
          var errorElement = document.getElementById("card-errors");
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server.
          stripeTokenHandler(result.token);
        }
      });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById("payment-form");
      var hiddenInput = document.createElement("input");
      var referral = localStorage.getItem("referral");
      if (referral) {
        var refInput = document.createElement("input");
        refInput.setAttribute("type", "hidden");
        refInput.setAttribute("name", "referral");
        refInput.setAttribute("value", referral);
        form.appendChild(refInput);
      }
      hiddenInput.setAttribute("type", "hidden");
      hiddenInput.setAttribute("name", "stripeToken");
      hiddenInput.setAttribute("value", token.id);

      form.appendChild(hiddenInput);

      // Submit the form
      form.submit();
    }
  });
})(jQuery);
// # sourceMappingURL=search.js.map
//# sourceMappingURL=search.js.ma
