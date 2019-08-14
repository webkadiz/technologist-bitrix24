<template>
  <div
    :class="classes"
    class="mdc-snackbar"
    @MDCSnackbar:closed="onClosed"
    @MDCSnackbar:closing="onClosing"
    @MDCSnackbar:opened="onOpened"
    @MDCSnackbar:opening="onOpening"
  >
    <div class="mdc-snackbar__surface">
      <div
        aria-live="polite"
        class="mdc-snackbar__label"
        role="status"
      >
        <slot />
      </div>
      <div
        v-if="hasDismiss || actionButtonText !== ''"
        class="mdc-snackbar__actions"
      >
        <button
          v-if="actionButtonText !== ''"
          class="mdc-button mdc-snackbar__action"
          type="button"
        />
        <button
          v-if="hasDismiss"
          class="mdc-icon-button mdc-snackbar__dismiss"
          :class="dismissClass"
          title="Dismiss"
        >
          <slot
            v-if="dismissClass === 'material-icons'"
            name="dismiss"
          >
            close
          </slot>
          <slot
            v-else
            name="dismiss"
          />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { MDCSnackbar } from '@material/snackbar'

export default {
  inheritAttrs: false,
  model: {
    prop: 'open',
    event: 'change'
  },
  props: {
    snackID: Number,
    theming: {
      type: String,
      default: ''
    },
    timeoutMs: {
      type: Number,
      default: 5000
    },
    closeOnEscape: {
      type: Boolean,
      default: true
    },
    labelText: {
      type: String,
      default: ''
    },
    actionButtonText: {
      type: String,
      default: ''
    },
    leading: {
      type: Boolean,
      default: false
    },
    stacked: {
      type: Boolean,
      default: false
    },
    hasDismiss: {
      type: Boolean,
      default: false
    },
    dismissClass: {
      type: String,
      default: 'material-icons'
    }
  },
  data () {
    return {
      mdcSnackbar: undefined
    }
  },
  computed: {
    classes () {
      return {
        'mdc-snackbar--leading': this.leading,
        'mdc-snackbar--stacked': this.stacked
      }
    }
  },
  watch: {
    snackID() {
      this.$nextTick(() => {
        this.mdcSnackbar.open()
      })
    },
    actionButtonText () {
      if (this.actionButtonText && this.actionButtonText !== '') this.mdcSnackbar.actionButtonText = this.actionButtonText
    },
    labelText () {
      if (this.labelText && this.labelText !== '') this.mdcSnackbar.labelText = this.labelText
    },
    closeOnEscape () {
      this.mdcSnackbar.closeOnEscape = this.closeOnEscape
    },
    timeoutMs () {
      this.mdcSnackbar.timeoutMs = this.timeoutMs
    }
  },
  mounted () {
    this.mdcSnackbar = MDCSnackbar.attachTo(this.$el)
    this.mdcSnackbar.timeoutMs = this.timeoutMs
    this.mdcSnackbar.closeOnEscape = this.closeOnEscape
    if (this.labelText && this.labelText !== '') this.mdcSnackbar.labelText = this.labelText
    if (this.actionButtonText && this.actionButtonText !== '') this.mdcSnackbar.actionButtonText = this.actionButtonText
    this.mdcSnackbar.open()
   
  },
  beforeDestroy () {
    this.mdcSnackbar.destroy()
  },
  methods: {
    onClosing (e) {
      this.$emit('closing', e.detail.reason)
    },
    onClosed (e) {
      this.$emit('closed', e.detail.reason)
    },
    onOpening () {
      this.$emit('opening')
    },
    onOpened () {
      this.$emit('opened')
    }
  }
}
</script>


<style scoped lang="scss">
  
@import "@material/snackbar/mdc-snackbar";
@import "@material/button/mdc-button";
@import "@material/icon-button/mdc-icon-button";

</style>