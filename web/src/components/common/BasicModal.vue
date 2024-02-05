<template>
    <div class="modal fade" ref="modalRef" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Title</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>Your paragraph here</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { defineComponent, ref, onMounted, onUnmounted } from 'vue'
import { Modal } from 'bootstrap'
export default defineComponent( {
    name: 'BasicModal',
    
    setup() {
        const modalRef = ref( null )
        let modalInstance = null

        onMounted( () => {
            modalInstance = new Modal( modalRef.value )
        } )

        onUnmounted( () => {
            if ( modalInstance ) {
                modalInstance.dispose()
            }
        } )

        const openModal = () => {
            if ( modalInstance ) {
                modalInstance.show()
            }
        }

        const closeModal = () => {
            if ( modalInstance ) {
                modalInstance.hide()
            }
        }

        return {
            modalRef,
            openModal,
            closeModal
        }
    }
})
</script>