using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class DTO_Auth_Obj
    {
        public int user_id { get; set; }
        public string token { get; set; }
        public object obj { get; set; }
    }

    public class DTO_User_Get
    {
        public int id { get; set; }
        public string login { get; set; } 
        public string sname { get; set; }
        public string fname { get; set; }
        public string patr { get; set; }
        public DTO_User_role role { get; set; }

      
        public string FIO()
        {
            return String.Format("{0} {1} {2}", sname, fname, patr);
        }
        public string shortFIO()
        {
            return String.Format("{0} {1}.{2}.", sname, fname[0], patr[0]);
        }
    }
    public class DTO_User_Create
    {
        public string Login { get; set; }
        public string Pass { get; set; }
        public string SName { get; set; }
        public string FName { get; set; }
        public string Patr { get; set; }
        public int RoleId { get; set; }
    }
    public class DTO_User_Auth
    {
        public int Id { get; set; }
        public string Login { get; set; }
        public string SName { get; set; }
        public string FName { get; set; }
        public string Patr { get; set; }
        public string Token { get; set; }
        public DTO_User_role Role { get; set; }
    }
    public class DTO_User_role
    {
        public int id { get; set; }
        public string title { get; set; }
    }
}
