using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using BaseDTO;
using Newtonsoft.Json;
namespace BaseDDC.Controllers
{
    [Route("Collections")]
    [ApiController]
    public class CollectionsController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();


        [Route("Get")]
        [HttpPost]
        public IActionResult Get([FromBody] DTO_Auth_Obj auth)
        {
            try
            {
                InfoCollection result = new InfoCollection()
                {
                    categories = AutoMapper.Mapper.Map<List<Category>, List<DTO_Category>>(_context.Category.ToList()),
                    cities = AutoMapper.Mapper.Map<List<City>, List<DTO_City>>(_context.City.ToList()),
                    genders = AutoMapper.Mapper.Map<List<Gender>, List<DTO_Gender>>(_context.Gender.ToList()),
                    heating_Types = AutoMapper.Mapper.Map<List<HeatingType>, List<DTO_Heating_Type>>(_context.HeatingType.ToList()),
                    type_Of_Houses = AutoMapper.Mapper.Map<List<TypeOfHouse>, List<DTO_Type_of_house>>(_context.TypeOfHouse.ToList()),
                    trainings = AutoMapper.Mapper.Map<List<Training>, List<DTO_Training>>(_context.Training.ToList()),
                    needs = AutoMapper.Mapper.Map<List<Need>, List<DTO_Need>>(_context.Need.ToList()),
                    donors = AutoMapper.Mapper.Map<List<Donor>, List<DTO_Donor>>(_context.Donor.ToList()),
                    helpTypes = AutoMapper.Mapper.Map<List<Helptype>, List<DTO_HelpType>>(_context.Helptype.ToList()),
                    user_Roles = AutoMapper.Mapper.Map<List<UserRole>,List<DTO_User_role>>(_context.UserRole.ToList())

                };
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
    }
}