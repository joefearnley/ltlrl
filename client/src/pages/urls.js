import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState } from 'react'
import AppLayout from '@/components/Layouts/AppLayout'
import Head from 'next/head'
import Button from '@/components/Button'

const Urls = () => {
    const [urls, setUrls] = useState([])
    const [isLoading, setLoading] = useState(true)

    const csrf = () => axios.get('/sanctum/csrf-cookie')

    useEffect(() => {
        csrf()

        axios
            .get('/api/urls')
            .then(response => {
                console.log(`response`);
                console.log(response.data.data);

                setUrls(response.data.data)
                setLoading(false)
          })
          .catch(error => console.log(error))
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
                                <p className="py-3"><a href="{url.little_url}">{url.little_url}</a></p>
                                <p className="py-1">{url.url}</p>
                                <p className="py-1 text-sm font-bold">{url.created_at}</p>
                            </div>
                            <div>
                                <Button className="ml-3 w-25 justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    Edit
                                </Button>

                                <Button className="ml-3 w-25 justify-center bg-persian_red hover:bg-persian_red-400 active:bg-persian_red focus:border-persian_red">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-4 h-4 mr-2">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Delete
                                </Button>
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
