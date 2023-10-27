import Input from '@/components/Input'
import InputError from '@/components/InputError'
import Label from '@/components/Label'
import Button from '@/components/Button'
import CopyToClipboard from '@/components/CopytoClipboard'
import axios from '@/lib/axios'
import { useState } from 'react'

const DeleteUrlButton = ({ className }) => {
    const [title, setTitle] = useState('')
    const [url, setUrl] = useState('')
    const [showModal, setShowModal] = useState(false)
    const [errors, setErrors] = useState([])
    const [littleUrl, setLittleUrl] = useState('')
    const csrf = () => axios.get('/sanctum/csrf-cookie')

    const openCreateUrlModal = () => {
        setShowModal(true)
    }

    const hideCreateUrlModal = () => {
        setShowModal(false)
        window.location.reload()
    }

    const submitForm = async event => {
        event.preventDefault()

        await csrf()

        setErrors([])

        axios
            .post('/api/urls', {
                title,
                url
            })
            .then(response => {
                if (response.data) {
                    setLittleUrl(response.data.data.little_url)
                }
            })
            .catch(error => {
                console.log(error)

                setErrors(error.response.data.errors)
            })
    }

    return (
        <>
            <Button
                className={`${className} m-auto`}
                onClick={openCreateUrlModal}
            >
                Create Url
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-4 h-4 ml-2">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </Button>
            <div className={`relative z-10 ${showModal ? 'block' : 'hidden'}`} aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div className="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div className="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div className="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        {littleUrl ? (
                            <>
                                <div className="px-4 py-3 text-center sm:mt-0 sm:text-left">
                                    <h3 className="text-base font-semibold leading-6 text-gray-900">Url Sucessfully Created</h3>
                                </div>
                                <div className="flex items-center justify-between w-full p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow bottom-5 left-5 dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800">
                                    <span>{littleUrl}</span>
                                    <CopyToClipboard copyText={littleUrl} />
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <Button className="ml-3 w-25 justify-center bg-dark_slate_gray hover:bg-dark_slate_gray-400 active:bg-dark_slate_gray focus:border-dark_slate_gray" onClick={hideCreateUrlModal}>Close</Button>
                                </div>
                            </>
                        ) : (
                            <form onSubmit={submitForm}>
                                <div className="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div className="sm:flex sm:items-start">
                                        <div className="mt-3 text-center sm:mt-0 sm:text-left">
                                            <h3 className="text-base font-semibold leading-6 text-gray-900" id="modal-title">Create Little URL</h3>
                                            <div className="mt-2">
                                                <p className="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                                            </div>
                                            {/* URL Title */}
                                            <div className="mt-4">
                                                <Label htmlFor="title">Title</Label>

                                                <Input
                                                    id="title"
                                                    type="text"
                                                    value={title}
                                                    className="block mt-1 w-full"
                                                    onChange={event => setTitle(event.target.value)}
                                                    required
                                                    autoFocus
                                                />

                                                <InputError messages={errors.email} className="mt-2" />
                                            </div>

                                            {/* URL */}
                                            <div className="mt-4 mb-4">
                                                <Label htmlFor="password">URL</Label>

                                                <Input
                                                    id="url"
                                                    type="url"
                                                    value={url}
                                                    className="block mt-1 w-full"
                                                    onChange={event => setUrl(event.target.value)}
                                                    required
                                                    autoComplete="current-url"
                                                />

                                                <InputError messages={errors.email} className="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <Button className="ml-3 w-25 justify-center">Save</Button>
                                    <Button className="ml-3 w-25 justify-center bg-dark_slate_gray hover:bg-dark_slate_gray-400 active:bg-dark_slate_gray focus:border-dark_slate_gray" onClick={hideCreateUrlModal}>Cancel</Button>
                                </div>
                            </form>
                        )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    )


export default DeleteUrlButton
