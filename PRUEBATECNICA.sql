PGDMP                       {         	   TECHNOKEY    16.1    16.1     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16397 	   TECHNOKEY    DATABASE     �   CREATE DATABASE "TECHNOKEY" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Colombia.1252';
    DROP DATABASE "TECHNOKEY";
                postgres    false            �          0    16398    usuarios 
   TABLE DATA           >   COPY public.usuarios (id, usuario, password, rol) FROM stdin;
    public          postgres    false    215   �       �          0    16405    vuelos 
   TABLE DATA           �   COPY public.vuelos (id, numero_vuelo, fecha_vuelo, empresa, h_salida, h_llegada, aeropuerto_salida, aeropuerto_llegada) FROM stdin;
    public          postgres    false    216   /       �           0    0    vuelos_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.vuelos_id_seq', 3, true);
          public          postgres    false    217            �   7   x�3����442�LL����,.)JL�/�2�L�K)J-K%���d�%b���� �)Z      �   e   x�e�K
�@��u�]Fz�1��J'a|0L\y�s(1 ����#>&��� /�c�Z�_=2�!I�ҿ�<Q�$�?��xN=%�!vG����Y�FUw�C�     