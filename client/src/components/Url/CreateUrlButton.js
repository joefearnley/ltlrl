import Input from '@/components/Input'
import InputError from '@/components/InputError'
import Label from '@/components/Label'
import Button from '@/components/Button'
import { useState } from 'react'

const CreateUrlButton = ({ className }) => {
    const [title, setTitle] = useState('')
    const [url, setUrl] = useState('')
    const [showModal, setShowModal] = useState(false)
    const [errors, setErrors] = useState([])

    const openCreateUrlModal = () => {

    }

    const submitForm = () => {

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
            <div className={showModal ? 'block' : 'hidden'}>
                <form onSubmit={submitForm}>
                    {/* URL Title */}
                    <div>
                        <Label htmlFor="title">Title</Label>

                        <Input
                            id="title"
                            type="title"
                            value={title}
                            className="block mt-1 w-full"
                            onChange={event => setTitle(event.target.value)}
                            required
                            autoFocus
                        />

                        <InputError messages={errors.email} className="mt-2" />
                    </div>

                    {/* URL */}
                    <div className="mt-4">
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
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <Button className="ml-3">Save</Button>
                        <Button className="ml-3">Cancel</Button>
                    </div>
                </form>
            </div>
        </>
    )
}

export default CreateUrlButton
