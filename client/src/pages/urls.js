import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState } from 'react'
import AppLayout from '@/components/Layouts/AppLayout'
import Head from 'next/head'
import Button from '@/components/Button'
import DeleteUrlButton from '@/components/Url/DeleteUrlButton'

const Urls = () => {
    const [urls, setUrls] = useState([])
    const [isLoading, setLoading] = useState(true)

    const csrf = () => axios.get('/sanctum/csrf-cookie')

    const loadUrlList = () => {
        csrf()

        axios
            .get('/api/urls')
            .then(response => {
                setUrls(response.data.data)
                setLoading(false)
          })
          .catch(error => console.log(error))
    }

    useEffect(() => {
        loadUrlList()
    }, [])

    return (
        <AppLayout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Urls
                </h2>
            }>
            <Head>
                <title>ltlrl - Urls</title>
            </Head>

            <div className="py-6">
            {urls.map((url, index) => (
                <div className="py-3" key={index}>
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-2">
                        <div className="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
                            <div className="bg-white">
                                <h2 className="font-bold text-lg">{url.title}</h2>
                                <p className="py-3"><a href={url.little_url}>{url.little_url}</a></p>
                                <p className="py-1">{url.url}</p>
                                <p className="py-1 text-sm font-bold">{url.created_at}</p>
                            </div>
                            <div>
                                <Button className="ml-3 w-25 justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-4 h-4 mr-2">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    Edit
                                </Button>

                                <DeleteUrlButton urlId={url.id} />
                            </div>
                        </div>
                    </div>
                </div>
            ))}
            </div>
        </AppLayout>
    )
}

export default Urls
