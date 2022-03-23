<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Forgot Password v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <!-- logo -->
            <b-img
                :src="logoUrl"
                alt="Login V2"
                class="z-index-0"
                width="150"
                height="45"
            />
        </b-link>

        <b-card-title class="mb-1">
          Forgot Password? 🔒
        </b-card-title>
        <b-card-text class="mb-2">
          Enter your email and we'll send you instructions to reset your password
        </b-card-text>

        <!-- form -->
        <validation-observer ref="simpleRules">
          <b-form
            class="auth-forgot-password-form mt-2"
            @submit.prevent="validationForm"
          >
            <!-- email -->
            <b-form-group
              label="Email"
              label-for="forgot-password-email"
            >
              <validation-provider
                #default="{ errors }"
                name="Email"
                rules="required|email"
              >
                <b-form-input
                  id="forgot-password-email"
                  v-model="user.email"
                  :state="errors.length > 0 ? false:null"
                  name="forgot-password-email"
                  placeholder="john@example.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- submit button -->
            <b-button
              variant="primary"
              block
              type="submit"
            >
              Send reset link
            </b-button>
          </b-form>
        </validation-observer>

        <b-card-text class="text-center mt-2">
          <b-link :to="{name:'auth-login'}">
            <feather-icon icon="ChevronLeftIcon" /> Back to login
          </b-link>
        </b-card-text>

      </b-card>
    <!-- /Forgot Password v1 -->
    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { BCard, BLink, BCardText, BCardTitle, BFormGroup, BFormInput, BForm, BButton, BImg, } from 'bootstrap-vue'
import { required, email } from '@validations'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'


export default {
  components: {
    BCard,
    BLink,
    BCardText,
    BCardTitle,
    BFormGroup,
    BFormInput,
    BButton,
    BForm,
    ValidationProvider,
    ValidationObserver,
      ToastificationContent,
      BImg,
  },
    data() {
        return {
            email: null,
            has_error: false,
            user: {
                email: '',
            },

            // validation
            required,
            email,
            logoUrl: require('@/assets/images/logo/logo.png'),
        }
    },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Reset Password Request Submitted',
              icon: 'EditIcon',
              variant: 'success',
            },
          })
            this.$http.post("/forgot-password", {email: this.user.email}).then(result => {
                this.response = result.data;
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Reset Password Request Submitted',
                  icon: 'EditIcon',
                  variant: 'success',
                },
              })

                console.log(result);
            }, error => {
                console.log(error.response.data)

                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error Resetting Password',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: `Please enter a valid email.`,
                        },
                    })

                debugger
                this.$refs.simpleRules.setErrors(error.response.data.error)
            });
        }
      })
    },
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-auth.scss';
</style>
