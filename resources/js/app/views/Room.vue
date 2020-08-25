<template>
  <div>
    <Header></Header>


        <RoomDetails :room='room' :disabledDates='disabledDates' :datesRange='datesRange' :bookingDetails='bookingDetails' @book-now="bookNow"/>


        <RoomAvailability :disabledDates='disabledDates' />



    <form action="#" @submit.prevent="checkoutNow(checkout.step)">
      <!-- CHECKOUT MODAL -->
      <div
        class="modal fade"
        id="checkoutModal"
        tabindex="-1"
        aria-labelledby="checkoutModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content rounded-0">
            <div class="modal-header">
              <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row bs-wizard" style="border-bottom:0;">
                <div
                  :class="['col-xs-3 bs-wizard-step', checkout.step === 1 ? 'active' : 'complete']"
                >
                  <div class="text-center bs-wizard-stepnum">Details</div>
                  <div class="progress">
                    <div class="progress-bar"></div>
                  </div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <!-- <div class="bs-wizard-info text-center">Details</div> -->
                </div>

                <div
                  :class="['col-xs-3 bs-wizard-step', checkout.step === 2 ? 'active' : (checkout.step === 1 ? 'disabled' : 'complete')]"
                >
                  <!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Confirmation</div>
                  <div class="progress">
                    <div class="progress-bar"></div>
                  </div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <!-- <div class="bs-wizard-info text-center">Payment</div> -->
                </div>

                <div
                  :class="['col-xs-3 bs-wizard-step', checkout.step === 3 ? 'active' : 'disabled']"
                >
                  <!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Payment</div>
                  <div class="progress">
                    <div class="progress-bar"></div>
                  </div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <!-- <div class="bs-wizard-info text-center">Payment</div> -->
                </div>
              </div>

              <div v-show="checkout.step === 1">
                <div class="row">
                  <div class="form-group col-12 col-md-6">
                    <label for="first_name">First name</label>
                    <input
                      v-model="bookingDetails.first_name"
                      type="text"
                      minlength="3"
                      class="form-control"
                      name="first_name"
                      id="first_name"
                      placeholder="First name"
                      required
                    />
                  </div>
                  <div class="form-group col-12 col-md-6">
                    <label for="last_name">Last name</label>
                    <input
                      v-model="bookingDetails.last_name"
                      type="text"
                      minlength="3"
                      class="form-control"
                      name="last_name"
                      id="last_name"
                      placeholder="Last name"
                      required
                    />
                  </div>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input
                    v-model="bookingDetails.email"
                    type="email"
                    class="form-control"
                    name="email"
                    id="email"
                    placeholder="email"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="phone">Phone number</label>
                  <input
                    v-model="bookingDetails.phone"
                    type="tel"
                    class="form-control"
                    name="phone"
                    id="phone"
                    placeholder="phone number"
                    required
                  />
                </div>

                <div class="row">
                  <div class="form-group col-12 col-md-6">
                    <label for="country">Country</label>
                    <input
                      v-model="bookingDetails.country"
                      type="text"
                      pattern="[a-zA-Z]+"
                      class="form-control"
                      name="country"
                      id="country"
                      placeholder="country"
                      required
                    />
                  </div>

                  <div class="form-group col-12 col-md-6">
                    <label for="city">City</label>
                    <input
                      v-model="bookingDetails.city"
                      type="text"
                      pattern="[a-zA-Z]+"
                      class="form-control"
                      name="city"
                      id="city"
                      placeholder="city"
                      required
                    />
                  </div>
                </div>

                <div class="form-group">
                  <label for="address">Address</label>
                  <input
                    v-model="bookingDetails.address"
                    type="text"
                    class="form-control"
                    name="address"
                    id="address"
                    placeholder="Address"
                    required
                  />
                </div>

                <div class="row">
                  <div class="form-group col-12 col-md-6">
                    <label for="postal_code">Postal code</label>
                    <input
                      v-model="bookingDetails.postal_code"
                      type="text"
                      class="form-control"
                      name="postal_code"
                      id="postal_code"
                      placeholder="Postal code"
                      required
                    />
                  </div>

                  <div class="form-group col-12 col-md-6">
                    <label for="state">State</label>
                    <input
                      v-model="bookingDetails.state"
                      type="text"
                      class="form-control"
                      name="state"
                      id="state"
                      placeholder="State"
                      required
                    />
                  </div>
                </div>
              </div>

              <div v-show="checkout.step === 2" class="py-4">
                <div>
                  <h4 class="text-center mb-3">Your contact information:</h4>

                  <div class="row">
                    <div class="col-md-6">Full name:</div>
                    <div
                      class="col-md-6"
                    >{{bookingDetails.first_name + ' ' + bookingDetails.last_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">Email:</div>
                    <div class="col-md-6">{{bookingDetails.email}}</div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">Phone Number:</div>
                    <div class="col-md-6">{{bookingDetails.phone}}</div>
                  </div>

                  <hr />

                  <div class="row">
                    <div class="col-md-6">Nights:</div>
                    <div class="col-md-6">{{calculNights}}</div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">Guests:</div>
                    <div class="col-md-6">{{bookingDetails.guests}}</div>
                  </div>

                  <hr />
                  <div class="d-flex flex-wrap justify-content-between">
                    <div>Subtotal:</div>
                    <div>{{calculPrice + '$'}}</div>
                  </div>
                  <div class="d-flex flex-wrap justify-content-between">
                    <div>Total:</div>
                    <div>{{calculPrice + '$'}}</div>
                  </div>
                </div>
              </div>
              <div class="row my-4">
                <div class="col-12 col-md-7 m-auto" v-show="checkout.step === 3">
                  <div class="form-group">
                    <label for="card-holder-name">Your name</label>
                    <input
                      type="text"
                      name="card_holder_name"
                      id="card-holder-name"
                      class="form-control"
                      placeholder
                    />
                  </div>

                  <div class="form-group">
                    <label for="card-element">Credit or debit card</label>
                    <div
                      id="card-element"
                      class="form-control"
                      style="height: 2.4em; padding-top: .7em;"
                    >
                      <!-- A Stripe Element will be inserted here. -->
                    </div>
                  </div>

                  <div class="alert alert-success" role="alert" v-show="processingPayment">
                    <strong>Processing payment...</strong>
                  </div>
                  <button
                    class="btn btn-warning rounded-0 text-white"
                    id="card-button"
                    :disabled="processingPayment"
                  >Process Payment</button>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary rounded-0"
                @click.prevent="checkout.step > 1 ? checkout.step-- : false"
              >Previous</button>
              <button
                type="submit"
                class="btn btn-primary rounded-0"
                :disabled="checkout.step === 3"
              >Next</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <Reviews :roomId="room.id"></Reviews>

    <Footer></Footer>

  </div>
</template>

<script>
import Header from "../partials/Header";
import Footer from "../partials/Footer";
import Reviews from "../components/Room/Reviews";
import RoomDetails from "../components/Room/RoomDetails";
import RoomAvailability from "../components/Room/RoomAvailability";
export default {
  components: {
    Header,
    Footer,
    Reviews,
    RoomDetails,
    RoomAvailability
  },
  data() {
    return {
      datesRange: null,
      roomId: window.roomId,
      room: {},
      disabledDates: [],
      processingPayment: false,
      checkout: {
        step: 1,
      },
      bookingDetails: {
        ...this.$store.state.user,
        guests: 1,
      },
    };
  },
  computed: {
    calculNights() {
      let oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
      if (this.datesRange) {
        let start = this.datesRange.start;
        let end = this.datesRange.end;

        let diffDays =
          Math.round(Math.abs((start.getTime() - end.getTime()) / oneDay)) + 1;
        console.log(start, "to", end, "\nDifference: " + diffDays + " day");
        return diffDays;
      }
      return null;
    },
    calculPrice() {
      if (this.calculNights) return this.calculNights * this.room.price;
      else return null;
    },
  },
  methods: {

    async getRoom() {
      this.processingPayment = true;

      try {
        const result = await axios.get(`/api/rooms/${this.roomId}`);
        this.room = result.data.room;

        this.disabledDates = result.data.room.bookings.map((obj) => {
          let dates = {};
          dates["start"] = new Date(obj.check_in);
          dates["end"] = new Date(obj.check_out);

          return dates;
        });

        this.disabledDates.push({
          start: null,
          end: new Date(),
        });
      } catch (error) {
        console.log(error);
      }

      this.$store.state.isLoading = false;
    },

    bookNow() {
      const userLoggedIn = this.$store.state.userToken;
      if (!userLoggedIn) {
        this.$store.dispatch("displayRegisterForm");
        return false;
      }
      $("#checkoutModal").modal("show");
    },

    checkoutNow(step) {
      if (step < 3) {
        this.checkout.step++;
      } else if (step === 3) {
        console.log("last step completed");
      }
    },

    makeStripeElements() {
      const stripe = Stripe("pk_test_3CYrTJYbUoNb4lg6ir2XuKvq00G6kIutil");
      const elements = stripe.elements();
      const cardElement = elements.create("card");
      cardElement.mount("#card-element");

      const cardHolderName = document.getElementById("card-holder-name");
      const cardButton = document.getElementById("card-button");

      cardButton.addEventListener("click", async (e) => {
        this.$store.state.isLoading = true;
        const { paymentMethod, error } = await stripe.createPaymentMethod(
          "card",
          cardElement,
          {
            billing_details: {
              name: cardHolderName.value,
              phone: this.bookingDetails.phone,
              email: this.bookingDetails.email,

            },
          }
        );

        if (error) {
          console.log(error);
        } else {
          // The card has been verified successfully...
          console.log(paymentMethod);

          let bookingDetails = {
            datesRange: this.datesRange,
            roomId: this.room.id,
            guests: this.bookingDetails.guests,
          };
          let invoiceDetails = { total: this.calculPrice };

          try {
            const payment = await axios.post(`/api/checkout`, {
              bookingDetails: bookingDetails,
              invoiceDetails: invoiceDetails,
              paymentMethod: paymentMethod,
            });
            window.location.replace("/thank-you");
          } catch (error) {
            console.log(error);
          }
        }

        this.$store.state.isLoading = true;
      });

      this.processingPayment = false;

    },
  },

  mounted() {
    this.getRoom();

    this.makeStripeElements();

    // Default axios headers
    const token = localStorage.getItem("user-token");
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`; // for all requests
  },

};
</script>

<style scoped>
/* .bs-wizard {
    margin-top: 20px;
} */

</style>
